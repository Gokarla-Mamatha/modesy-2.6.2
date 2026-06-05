<input type="hidden" value="<?= $commentLimit; ?>" id="blog_comment_limit">
<ul class="blog-comments">
    <?php if (!empty($comments)):
        foreach ($comments as $comment): ?>
            <li>
                <div class="left">
                    <img src="<?= getUserAvatar($comment->user_avatar, $comment->user_storage_avatar); ?>" class="" alt="user">
                </div>
                <div class="right">
                    <p><span class="username"><?= esc($comment->name); ?></span></p>
                    <p class="comment"><?= esc($comment->comment); ?></p>
                    <p>
                        <span class="date"><?= timeAgo($comment->created_at); ?></span>
                        <?php if (authCheck()):
                            if ($comment->user_id == user()->id): ?>
                                <button type="button" class="button-link btn-delete-comment js-delete-blog-comment" data-comment-id="<?= esc($comment->id, 'attr'); ?>" data-post-id="<?= esc($commentPostId, 'attr'); ?>" data-msg="<?= esc(trans("confirm_comment", true), 'attr'); ?>" aria-label="delete-blog-comment-<?= esc($comment->id, 'attr'); ?>">&nbsp;<i class="icon-trash"></i>&nbsp;<?= esc(trans("delete")); ?></button>
                            <?php endif;
                        endif; ?>
                    </p>
                </div>
            </li>
        <?php endforeach;
    endif; ?>
</ul>
<?php if ($commentsCount > $commentLimit): ?>
    <div id="load_comment_spinner" class="col-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <button class="btn-load-more js-load-more-blog-comments" data-post-id="<?= esc($commentPostId, 'attr'); ?>">
                <?= esc(trans("load_more")); ?>
            </button>
        </div>
    </div>
<?php endif; ?>
