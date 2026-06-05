<?php if (!empty($comments)):
    foreach ($comments as $comment): ?>
        <li id="li-comment-<?= $comment->id; ?>">
            <div class="left">
                <?php if (!empty($comment->user_slug)): ?>
                    <a href="<?= generateProfileUrl($comment->user_slug); ?>">
                        <img data-src="<?= getUserAvatar($comment->user_avatar, $comment->user_storage_avatar); ?>" alt="<?= esc($comment->name); ?>" class="lazyload">
                    </a>
                <?php else: ?>
                    <img data-src="<?= getUserAvatar($comment->user_avatar, $comment->user_storage_avatar); ?>" alt="<?= esc($comment->name); ?>" class="lazyload">
                <?php endif; ?>
            </div>
            <div class="right">
                <div class="row-custom">
                    <p class="username">
                        <?= (!empty($comment->user_slug)) ? '<a href="' . generateProfileUrl($comment->user_slug) . '">' : '';
                        if (!empty($comment->user_id)):
                            echo !empty($comment->user_username) ? esc($comment->user_username) : esc($comment->name);
                        else:
                            echo esc($comment->name);
                        endif;
                        echo (!empty($comment->user_slug)) ? '</a>' : ''; ?>
                    </p>
                </div>
                <div class="row-custom comment">
                    <?= esc($comment->comment); ?>
                </div>
                <div class="row-custom">
                    <span class="date"><?= timeAgo($comment->created_at); ?></span>

                    <?php if(authCheck()):?>
                        <button type="button" class="button-link js-show-comment-form" data-comment-id="<?= esc($comment->id, 'attr'); ?>" aria-label="reply-comment-<?= esc($comment->id, 'attr'); ?>"><i class="icon-reply"></i> <?= esc(trans('reply')); ?></button>
                    <?php else: ?>
                        <button type="button" class="button-link" data-toggle="modal" data-target="#loginModal" aria-label="reply-comment-<?= esc($comment->id, 'attr'); ?>"><i class="icon-reply"></i> <?= esc(trans('reply')); ?></button>
                    <?php endif; ?>

                    <?php if (authCheck()):
                        if ($comment->user_id == user()->id || hasPermission('comments')): ?>
                            <button type="button" class="button-link js-delete-product-comment" aria-label="delete-comment-<?= esc($comment->id, 'attr'); ?>" data-comment-id="<?= esc($comment->id, 'attr'); ?>" data-type="comment" data-msg="<?= esc(trans("confirm_comment", true), 'attr'); ?>">&nbsp;<i class="icon-trash"></i>&nbsp;<?= esc(trans("delete")); ?></button>
                        <?php endif;
                    endif;
                    if (authCheck()): ?>
                        <?php if ($comment->user_id != user()->id): ?>
                            <button type="button" class="button-link link-abuse-report js-report-product-comment" data-toggle="modal" data-target="#reportCommentModal" aria-label="about-report-<?= esc($comment->id, 'attr'); ?>" data-comment-id="<?= esc($comment->id, 'attr'); ?>"><?= esc(trans("report")); ?></button>
                        <?php endif;
                    else: ?>
                        <button type="button" class="button-link link-abuse-report" data-toggle="modal" data-target="#loginModal" aria-label="about-report-<?= esc($comment->id, 'attr'); ?>"><?= esc(trans("report")); ?></button>
                    <?php endif; ?>
                </div>
                <div id="subCommentForm<?= $comment->id; ?>" class="row-custom row-sub-comment visible-sub-comment">
                </div>
                <div class="row-custom row-sub-comment">
                    <?= view('product/details/_subcomments', ['parentComment' => $comment, 'commentsArray' => $commentsArray]); ?>
                </div>
            </div>
        </li>
    <?php endforeach;
endif; ?>
