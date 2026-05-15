<?php

namespace App\Controllers;

use App\Models\ForumCategoryModel;

class AdminForumCategoryController extends BaseAdminController
{
    public $forumCategoryModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->forumCategoryModel = new ForumCategoryModel();
    }

    // Categories page
    public function categories()
    {
        checkPermission('categories');

        $data['title'] = trans("categories");
        $q = cleanStr(inputGet('q'));

        if (!empty($q)) {
            $data['searchMode'] = true;
            $data['categories'] = $this->forumCategoryModel->getCategoriesWithThreadCount($q);
        } else {
            $data['searchMode'] = false;
            $data['categories'] = $this->forumCategoryModel->getCategoriesWithThreadCount();
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/forums/categories', $data);
        echo view('admin/includes/_footer');
    }

    // Add category form
    public function addCategory()
    {
        checkPermission('categories');
        $data['title'] = trans("add_category");
      
        echo view('admin/includes/_header', $data);
        echo view('admin/forums/add_category', $data);
        echo view('admin/includes/_footer');
    }

    // Add category POST
    public function addCategoryPost()
    {
        checkPermission('categories');

        if ($this->forumCategoryModel->addCategory()) {
            setSuccessMessage(trans("msg_added"));
        } else {
            setErrorMessage(trans("msg_error"));
        }

        redirectToBackUrl();
    }

    // Edit category form
    public function editCategory($id)
    {
        checkPermission('categories');

        $category = $this->forumCategoryModel->getCategory($id);
        if (empty($category)) {
            return redirect()->to(adminUrl('forums/categories'));
        }

        $data['title'] = trans("update_category");
        $data['category'] = $category; 

        echo view('admin/includes/_header', $data);
        echo view('admin/forums/edit_category', $data);
        echo view('admin/includes/_footer');
    }

    // Edit POST
    public function editCategoryPost()
    {
        checkPermission('categories');

        $id = inputPost('id');
        if ($this->forumCategoryModel->updateCategory($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }

        redirectToBackUrl();
    }

    // Delete category
    public function deleteCategoryPost()
    {
        checkPermission('categories');

        $id = inputPost('id');
        if ($this->forumCategoryModel->deleteCategory($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    public function deleteCategoryImagePost()
    {
        checkPermission('categories');
        $categoryId = inputPost('category_id');
        $this->forumCategoryModel->deleteCategoryImage($categoryId);
        return jsonResponse();
    }
}
