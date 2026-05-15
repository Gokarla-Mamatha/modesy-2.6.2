<?php namespace App\Models;

use CodeIgniter\Model;

class ForumCategoryModel extends Model
{
    protected $db;
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('forum_categories');
    }

    /*
     * --------------------------------------------------------------------
     * GET CATEGORY
     * --------------------------------------------------------------------
     */
    public function getCategory($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    /*
     * --------------------------------------------------------------------
     * INPUT VALUES
     * --------------------------------------------------------------------
     */
    public function inputValues()
    {
        $data = [];
       
        $slug = cleanStr(inputPost('slug'));
        if (empty($slug)) {
            $slug = url_title(inputPost('name'), '-', true);
        }

        $data['slug']        = $slug;
        $data['name']        = inputPost('name_1');
        $data['description'] = inputPost('description');
        $data['sort_order']  = clrNum(inputPost('sort_order'));
        $data['is_active']   = !empty(inputPost('is_active')) ? 1 : 1;
        $data['storage']     = 'local';   // ⭐ default storage
        $data['updated_at']  = date('Y-m-d H:i:s'); 
        return $data;
    }

    /*
     * --------------------------------------------------------------------
     * ADD CATEGORY
     * --------------------------------------------------------------------
     */
    public function addCategory()
    {
        $data = $this->inputValues();
        $data['created_at'] = date('Y-m-d H:i:s');

        // Handle image upload
        $uploadModel = new \App\Models\UploadModel();
        $tempFile = $uploadModel->uploadTempFile('file');

        if (!empty($tempFile['path'])) {
            $data['thumbnail'] = $uploadModel->uploadCategoryImage($tempFile['path']);
            $data['storage']   = 'local';
            $uploadModel->deleteTempFile($tempFile['path']);
        }

        $this->builder->insert($data);
        $lastId = $this->db->insertID();

        $this->updateSlug($lastId);

        return $lastId;
    }

    /*
     * --------------------------------------------------------------------
     * UPDATE CATEGORY
     * --------------------------------------------------------------------
     */
    public function updateCategory($id)
    {
        $category = $this->getCategory($id);
        if (empty($category)) return false;

        $data = $this->inputValues();

        // Image upload
        $uploadModel = new \App\Models\UploadModel();
        $tempFile = $uploadModel->uploadTempFile('file');

        if (!empty($tempFile['path'])) {
            // Upload new thumbnail
            $data['thumbnail'] = $uploadModel->uploadCategoryImage($tempFile['path']);
            $data['storage']   = 'local';

            // Delete old file
            if (!empty($category->thumbnail)) {
                deleteStorageFile($category->thumbnail, $category->storage);
            }

            $uploadModel->deleteTempFile($tempFile['path']);
        } else {
            // Preserve old thumbnail
            $data['thumbnail'] = $category->thumbnail;
            $data['storage']   = $category->storage;
        }

        $this->builder->where('id', clrNum($id))->update($data);

        $this->updateSlug($id);

        return true;
    }

    /*
     * --------------------------------------------------------------------
     * DELETE CATEGORY
     * --------------------------------------------------------------------
     */
    public function deleteCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category->thumbnail)) {
            deleteStorageFile($category->thumbnail, $category->storage);
        }

        return $this->builder->where('id', clrNum($id))->delete();
    }

    /*
     * --------------------------------------------------------------------
     * UPDATE SLUG
     * --------------------------------------------------------------------
     */
    public function updateSlug($id)
    {
        $category = $this->getCategory($id);
        if (empty($category)) return;

        $slug = cleanStr($category->slug);
        if (empty($slug)) {
            $slug = url_title($category->name, '-', true);
        }

        // Check duplicates
        $exists = $this->builder
            ->where('slug', $slug)
            ->where('id !=', $id)
            ->countAllResults();

        if ($exists > 0) {
            $slug = $slug . '-' . $id;
        }

        $this->builder->where('id', $id)->update(['slug' => $slug]);
    }

    /*
     * --------------------------------------------------------------------
     * CATEGORIES WITH THREAD COUNT
     * --------------------------------------------------------------------
     */
    public function getCategoriesWithThreadCount($q = null)
    {
        $builder = $this->db->table('forum_categories fc');

        $builder->select('fc.*,
            (SELECT COUNT(*) FROM forum_threads ft 
             WHERE ft.category_id = fc.id AND ft.status="approved") AS thread_count
        ');

        if (!empty($q)) {
            $builder->like('fc.name', $q, 'after');
        }

        return $builder->orderBy('fc.sort_order', 'ASC')->get()->getResultArray();
    }

    /*
     * --------------------------------------------------------------------
     * ACTIVE CATEGORIES
     * --------------------------------------------------------------------
     */
    public function getActiveCategories()
    {
        return $this->builder
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getActiveCategoriesWithThreadCount()
    {
        return $this->db->table('forum_categories fc')
            ->select('fc.*, 
                (SELECT COUNT(*) FROM forum_threads ft 
                 WHERE ft.category_id = fc.id AND ft.status="approved") AS thread_count')
            ->where('fc.is_active', 1)
            ->orderBy('fc.sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }

    /*
     * --------------------------------------------------------------------
     * FIND BY SLUG
     * --------------------------------------------------------------------
     */
    public function getCategoryBySlug($slug)
    {
        return $this->builder->where('slug', cleanStr($slug))->get()->getRow();
    }

public function deleteCategoryImage($categoryId)
{
    $category = $this->getCategory($categoryId);
    if (empty($category) || empty($category->thumbnail)) {
        return false;
    }

    // delete old file from storage
    deleteStorageFile($category->thumbnail, $category->storage);

    // update DB
    return $this->builder
        ->where('id', $category->id)
        ->update([
            'thumbnail' => '',
            'storage'   => 'local'
        ]);
}
public function getTopCategories()
{
    return $this->db->table('forum_categories fc')
        ->select('
            fc.*,
            COUNT(DISTINCT ft.id) AS thread_count,
            COALESCE(MAX(rc.replies_count), 0) AS max_replies
        ')
        ->join('forum_threads ft', 'ft.category_id = fc.id', 'left')
        ->join(
            '(SELECT thread_id, COUNT(*) AS replies_count 
              FROM forum_posts 
              GROUP BY thread_id) rc',
            'rc.thread_id = ft.id',
            'left'
        )
        ->groupBy('fc.id')
        ->orderBy('max_replies', 'DESC')
        ->orderBy('thread_count', 'DESC')
        ->get()
        ->getResultArray();
}
}
