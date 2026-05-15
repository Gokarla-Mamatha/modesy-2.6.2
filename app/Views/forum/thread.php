<?php
function renderRepliesRecursive($replies, $level = 1, $threadLocked = false, $thread = null, $hideReplies = 0){
if ($hideReplies == 1) {
    return;
} 
    foreach ($replies as $reply): ?>

<div class="comment-box nested-comment level-<?= $level ?>">
    <div class="user-avatar">
        <?php if (!empty($reply['is_anonymous'])): ?>
        <img src="<?= base_url('uploads/default.png') ?>">
        <?php else: ?>
        <img src="<?= getUserAvatar($reply['avatar'] ?? null) ?>">
        <?php endif; ?>
    </div>

    <div class="comment-body">
        <?php if (!empty($reply['is_anonymous'])): ?>
        <span class="username">Anonymous User</span>
        <?php else: ?>
        <a href="<?= base_url('profile/' . $reply['user_slug']) ?>" class="username">
            <?= esc($reply['username']) ?>
        </a>
        <?php endif; ?>
        <p><?= nl2br(esc($reply['content'])) ?></p>

        <!-- Unified Actions: Reply button + Replies count in one line -->
        <div class="comment-actions d-flex align-items-center gap-3 mt-2">

            <?php if(authCheck()  && !$threadLocked): ?>
            <button class="reply-btn btn-reply-to-post" type="button" data-username="<?= esc($reply['username']) ?>"
                data-post-id="<?= $reply['id'] ?>"
                data-content="<?= esc(substr(strip_tags($reply['content']), 0, 120)) ?>">
                💬 Reply
            </button>
            <?php endif; ?>

            <?php if (!empty($reply['replies'])): ?>
            <div class="reply-toggle d-flex align-items-center" data-target="#replies-<?= $reply['id'] ?>">
                <span class="reply-icon">💬</span>
                <span class="reply-count">
                    <?= count($reply['replies']) ?> <?= count($reply['replies']) > 1 ? 'Replies' : 'Reply' ?>
                </span>
                <span class="toggle-icon ms-2">▼</span>
            </div>
            <?php endif; ?>
            <?php if (authCheck() && ( (isset($thread) && user()->id == $thread->user_id) || isAdmin())): ?>
                <button class="delete-reply-btn delete-icon-btn" data-id="<?= $reply['id'] ?>"> Delete</button>
            <?php endif; ?>

        </div>

        <div class="reply-box-container" id="reply-box-<?= $reply['id'] ?>"></div>

        <!-- Recursive Nested Replies -->
        <?php if (!empty($reply['replies'])): ?>
        <div class="nested-replies" id="replies-<?= $reply['id'] ?>">
           <?php renderRepliesRecursive($reply['replies'], $level + 1, $threadLocked, $thread, $hideReplies); ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php endforeach; } ?>

<div class="container mt-4 mb-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-white p-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="<?= base_url('forum') ?>">Forum Home</a></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url('forum/category/' . $thread->category_slug) ?>"><?= esc($thread->category_name) ?></a>
            </li>
            <li class="breadcrumb-item active"><?= esc($thread->title) ?></li>
        </ol>
    </nav>

    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm sticky-sidebar">
                <div class="card-header bg-light font-weight-bold">📂 Categories</div>
                <ul class="list-group list-group-flush">
                    <?php foreach($categories as $cat): ?>
                    <li class="list-group-item <?= $cat['id'] == $thread->category_id ? 'active' : '' ?>">
                        <a href="<?= base_url('forum/category/' . $cat['slug']) ?>"
                            class="<?= $cat['id'] == $thread->category_id ? 'text-white' : 'text-dark' ?>">
                            <?= esc($cat['name']) ?>
                            <span class="badge badge-secondary float-right"><?= $cat['thread_count'] ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9">
            <?php $hideReplies = $thread->hide_replies; ?>


            <!-- Thread Header -->
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                       <?php if (!empty($thread->thumbnail)): ?>
                            <img src="<?= base_url($thread->thumbnail); ?>"
                                style="width:90px;height:90px;object-fit:cover;border-radius:10px;margin-bottom:8px;">
                        <?php else: ?>
                            <img src="<?= base_url('uploads/default-thread.png'); ?>"
                                style="width:90px;height:90px;object-fit:cover;border-radius:10px;margin-bottom:8px;">
                        <?php endif; ?>   
                    <h3><?= esc($thread->title) ?></h3>
                    <?php if (!empty($tags)): ?>
                        <div class="thread-tags mt-2 mb-3">
                            <?php foreach ($tags as $tag): ?>
                                <span class="badge badge-primary mr-1">
                                    #<?= esc($tag['name']); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $threadUrl = urlencode(base_url('forum/thread/' . $thread->slug));
                    $ThreadTitle = urlencode($thread->title);
                    ?>
                    <div class="thread-share mb-3">
                        <ul class="share-list">
                            <li><button
                                    onclick='window.open("https://www.facebook.com/sharer/sharer.php?u=<?= $threadUrl ?>")'><i
                                        class="icon-facebook"></i></button></li>
                            <li><button
                                    onclick='window.open("https://twitter.com/share?url=<?= $threadUrl ?>&text=<?= $ThreadTitle ?>")'><i
                                        class="icon-twitter"></i></button></li>
                            <li><a href="https://api.whatsapp.com/send?text=<?= $ThreadTitle ?> - <?= $threadUrl ?>"
                                    target="_blank"><i class="icon-whatsapp"></i></a></li>
                            <li><button
                                    onclick='window.open("http://pinterest.com/pin/create/button/?url=<?= $threadUrl ?>")'><i
                                        class="icon-pinterest"></i></button></li>
                            <li><button
                                    onclick='window.open("http://www.linkedin.com/shareArticle?mini=true&url=<?= $threadUrl ?>")'><i
                                        class="icon-linkedin"></i></button></li>
                            <li><button
                                    onclick='window.open("https://t.me/share/url?url=<?= $threadUrl ?>&text=<?= $ThreadTitle ?>")'><i
                                        class="icon-telegram"></i></button></li>
                        </ul>
                    </div>
                    <div class="flex">
                        <div class="text-muted small mb-2">
                            <i class="icon-user"></i> <?= esc($thread->username) ?> |
                            <i class="icon-eye"></i> <?= esc($thread->views_count) ?> views |
                            <i class="icon-clock"></i> <?= timeAgo($thread->created_at) ?>
                        </div>

                    </div>
                    <hr>
                    <p><?= nl2br(esc($thread->content)) ?></p>
                    <?php if (!empty($attachments)): ?>
                        <div class="thread-attachments mt-3">
                            <h6>📎 Attachments</h6>

                            <?php foreach ($attachments as $file): ?>

                                <?php if (strpos($file['file_type'], 'image') !== false): ?>
                                    <img src="<?= base_url($file['file_path']) ?>" 
                                        class="img-thumbnail mb-2" 
                                        style="max-width:200px;">
                                <?php else: ?>
                                    <div class="mb-2">
                                        <a href="<?= base_url($file['file_path']) ?>" 
                                        target="_blank" 
                                        class="btn btn-sm btn-outline-primary">
                                            📄 <?= esc($file['file_name']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Write Reply -->
            <?php if (authCheck()  && !$thread->is_locked && $thread->hide_replies == 0): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5>💬 Write a Reply</h5>
                    <form class="main-reply-form" method="post" action="<?= base_url('forum/reply/' . $thread->id) ?>">
                        <?= csrf_field() ?>
                        <textarea name="content" id="replyBox" class="form-control emoji-enabled" rows="4" required></textarea>
                        <div class="mt-2"><input type="file" name="attachment" id="replyAttachment" class="form-control"></div>
                        <small id="attachment-error" class="text-danger d-block mt-1"></small>
                        <div class="mt-2">
                            <label>
                                <input type="checkbox" name="is_anonymous" value="1"> Post as Anonymous
                            </label>
                        </div>
                        <button class="btn btn-custom mt-3 main-reply-btn" type="submit">Post Reply</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- Display Posts -->
             <?php if ($hideReplies == 0): ?>

            <?php foreach($posts as $post): 
                  if (!empty($post['parent_post_id']) && isset($structured[$post['parent_post_id']])) {
                        $structured[$post['parent_post_id']]['replies'][] = $post;
                    }?>
            <?php
            $attachments = model('App\Models\ForumAttachmentModel')
                ->where('post_id', $post['id'])
                ->findAll();
            ?>
            <div class="comment-box  best-answer-card ">
                <div class="comment-content-wrapper">
                    <div class="user-avatar">
                        <?php if (!empty($reply['is_anonymous'])): ?>
                            <img src="<?= base_url('uploads/default.png'); ?>">
                        <?php else: ?>
                            <img src="<?= getUserAvatar($reply['avatar'] ?? null); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="comment-body">
                       <div class="comment-header">
                            <?php if (!empty($post['is_anonymous'])): ?>
                                <span class="username">Anonymous User</span>
                            <?php else: ?>
                                <a href="<?= base_url('profile/' . $post['user_slug']) ?>" class="username">
                                    <?= esc($post['username']) ?>
                                </a>
                            <?php endif; ?>
                            <span class="time"><?= timeAgo($post['created_at']) ?></span>
                        </div>

                        <p class="comment-text"><?= nl2br(esc($post['content'])) ?></p>
                      <?php if (!empty($attachments)): ?>
                        <div class="mt-2">
                            <?php foreach ($attachments as $file): ?>
                                <?php 
                                    $ext = strtolower(pathinfo($file['file_name'], PATHINFO_EXTENSION));
                                ?>
                                <?php if (strpos($file['mime_type'], 'image') !== false): ?>
                                    <img src="<?= base_url($file['file_path']) ?>" 
                                        class="img-thumbnail mb-2" 
                                        style="max-width:60px; height:auto; border-radius:6px;">
                                <?php elseif ($file['mime_type'] === 'application/pdf' && $ext === 'pdf'): ?>
                                    <div class="mb-2">
                                        <a href="<?= base_url($file['file_path']) ?>" 
                                        target="_blank" 
                                        class="btn btn-sm btn-outline-primary">
                                            📎 <?= esc($file['file_name']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                        <div class="reaction-buttons  <?= $thread->is_locked ? 'disabled-reactions' : '' ?>">
                            <?php foreach (['like'=>'👍','love'=>'❤️','laugh'=>'😂','angry'=>'😡','sad'=>'😢'] as $type=>$icon): ?>
                            <button class="react <?= $post['user_reaction'] == $type ? 'active' : '' ?>"
                                data-post="<?= $post['id'] ?>" data-type="<?= $type ?>">
                                <?= $icon ?> <span><?= $post['reactions'][$type] ?? 0 ?></span>
                            </button>
                            <?php endforeach; ?>
                            <div class="comment-actions d-flex align-items-center gap-3 mt-2">

                                <?php if (authCheck()  && !$thread->is_locked): ?>
                                <button class="reply-btn  btn-reply-to-post"
                                    data-username="<?= esc($post['username']) ?>" data-post-id="<?= $post['id'] ?>"
                                    data-content="<?= esc(substr(strip_tags($post['content']), 0, 120)) ?>">
                                    💬 Reply
                                </button>
                                <?php endif; ?>

                            <?php if (!empty($post['replies']) && $hideReplies == 0): ?>
                                <div class="reply-toggle d-flex align-items-center"
                                    data-target="#replies-<?= $post['id'] ?>">
                                    <span class="reply-icon">💬</span>
                                    <span class="reply-count"><?= count($post['replies']) ?> Replies</span>
                                    <span class="toggle-icon ms-1">▼</span>
                                </div>
                                <?php endif; ?>
                                 <?php if (authCheck() && ( (isset($thread) && user()->id == $thread->user_id) || isAdmin())): ?>
                                    <button class="delete-reply-btn delete-icon-btn" data-id="<?= $post['id'] ?>">Delete  </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="reply-box-container" id="reply-box-<?= $post['id'] ?>"></div>
                        <!-- Nested Replies -->
                         <?php if ($hideReplies == 0): ?>
                        <div class="nested-replies" id="replies-<?= $post['id'] ?>">
                           <?php renderRepliesRecursive($post['replies'], 1, $thread->is_locked, $thread); ?>
                        </div>
                
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
    </div>
</div>

<!-- Reaction Modal -->
<div class="modal fade" id="reactionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">People who reacted</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" <?= csp_script_nonce() ?>></script>


<script <?= csp_script_nonce() ?>>
    window.onload = function() {
        (function() {
            // Load EmojiOneArea JS ONLY if not already loaded
            if (typeof $.fn.emojioneArea === "undefined") {
                var script = document.createElement("script");
                script.src = "https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js";
                document.head.appendChild(script);
            }
        })();
        // Toggle nested replies
        $(document).on('click', '.reply-toggle', function() {
            let target = $(this).data('target');
            let replies = $(target);

            replies.slideToggle();
            let isVisible = replies.is(':visible');
            $(this).find('.toggle-icon').text(isVisible ? '▲' : '▼');
        });

        // Inline reply box
        $(document).on('click', '.btn-reply-to-post', function(e) {
            e.preventDefault();
            let postId = $(this).data('post-id');
            let username = $(this).data('username');
            let quoted = $(this).data('content');

            $('.reply-box-container').hide().empty();

            let replyForm = `
<div class="reply-form-wrapper">
    <form class="ajax-reply-form" method="post" action="<?= base_url('forum/reply/' . $thread->id) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="parent_id" value="${postId}">
        
        <textarea name="content" class="form-control reply-textarea emoji-enabled" rows="3" 
                  placeholder="Write your reply..." required></textarea>
                  <div class="mt-1">
                   <div class="mt-2"><input type="file" name="attachment" id="replyAttachment" class="form-control"></div>
                    <small id="attachment-error" class="text-danger d-block mt-1"></small>
                    <label style="font-size:13px;">
                        <input type="checkbox" name="is_anonymous" value="1"> Post as Anonymous
                    </label>
                </div>         
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-sm btn-custom" type="submit">Send Reply</button>
            <button type="button" class="btn btn-sm btn-light btn-cancel-reply">Cancel</button>
        </div>
    </form>
</div>`;

            $('#reply-box-' + postId).html(replyForm).show();
        });

        $(document).on('click', '.btn-cancel-reply', function() {
            $(this).closest('.reply-box-container').hide().empty();
        });
        $(document).on('submit', '.main-reply-form', function(e) {
            e.preventDefault(); // Stop full page reload

            let form = $(this);
            let submitBtn = form.find('.main-reply-btn');

                // Fetch emoji input value safely
            let emojiData = $("#replyBox").data("emojioneArea") ?
                $("#replyBox").data("emojioneArea").getText() :
                $("#replyBox").val();
            submitBtn.prop('disabled', true).text('Posting...');
                let formData = new FormData(form[0]);
                formData.set('content', emojiData);
                formData.set('parent_id', '');
                formData.set('is_anonymous', $('input[name="is_anonymous"]').is(':checked') ? 1 : 0);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                success: function(res) {
                    submitBtn.prop('disabled', false).text('Post Reply');

                        if (res.status === 'success') {
                        location.reload();
                        // let newPost = `
                        // <div class="comment-box nested-comment level-1 new-reply" id="reply-${res.reply.id}">
                        //     <div class="user-avatar">
                        //         <img src="${res.reply.avatar ? '<?= base_url() ?>/' + res.reply.avatar : '<?= base_url('uploads/default.png') ?>'}">
                        //     </div>
                        //     <div class="comment-body">
                        //         <a href="<?= base_url('profile/') ?>/${res.reply.user_slug}" class="username">${res.reply.username}</a>
                        //         <p>${res.reply.content}</p>
                        //     </div>
                        // </div>`;

                        // // Append at top or bottom (based on your design)
                        // $(".col-md-9").find(".comment-box").first().before(newPost);

                        // // Clear input properly
                        // if ($("#replyBox").data("emojioneArea")) {
                        //     $("#replyBox").data("emojioneArea").setText('');
                        // } else {
                        //     $("#replyBox").val('');
                        // }

                        // // Scroll to new reply
                        // $('html, body').animate({
                        //     scrollTop: $('#reply-' + res.reply.id).offset().top - 200
                        // }, 600);

                    } else {
                         $("#attachment-error").text(res.message);
                    }
                },
                error: function() {
                    submitBtn.prop('disabled', false).text('Post Reply');
                    alert('Error posting reply. Try again.');
                }
            });
        });


        $(document).on('click', '.react', function(e) {
            if ($(this).parent().is(':disabled') || $(this).parent().hasClass('disabled')) {
                e.preventDefault();
                return false;
            }
            let postId = $(this).data('post');
            let type = $(this).data('type');
            let buttonGroup = $(this).closest('.reaction-buttons');

            $.post("<?= base_url('forum/react-post') ?>", {
                post_id: postId,
                type: type
            }, function(res) {

                if (res.status !== 'success') {
                    alert(res.message || 'Something went wrong!');
                    return;
                }

                // Update counts
                for (let t in res.counts) {
                    buttonGroup.find('.react[data-type="' + t + '"] span').text(res.counts[t]);
                }

                // Clear previous active
                buttonGroup.find('.react').removeClass('active');

                // Set new active if user reacted
                if (res.user_reaction) {
                    buttonGroup.find('.react[data-type="' + res.user_reaction + '"]').addClass(
                        'active');
                }

            }, 'json');
        });

    $(document).on('click', '.react span', function(e) {
        e.stopPropagation();
        let button = $(this).closest('.react');
        let postId = button.data('post');
        let type   = button.data('type');
        $.get("<?= base_url('forum/post-reactions') ?>/" + postId + "/" + type, function(res) {
            if (res.status !== 'success') {
                alert(res.message);
                return;
            }
            let html = '';
            if (res.data.length === 0) {
                html = '<p>No users reacted yet.</p>';
            } else {
                res.data.forEach(function(user) {
                    html += `
                        <div class="d-flex align-items-center mb-2">
                            <img src="${user.avatar ? user.avatar : '<?= base_url('uploads/default.png') ?>'}"
                                style="width:36px;height:36px;border-radius:50%;margin-right:10px;">
                            <div>
                                <strong>${user.username}</strong><br>
                                <small>${type.toUpperCase()}</small>
                            </div>
                        </div>
                    `;
                });
            }
            $('#reactionsModal .modal-body').html(html);
            $('#reactionsModal').modal('show');
        }, 'json');
    });
    };
</script>
<script <?= csp_script_nonce() ?>>
    document.addEventListener("DOMContentLoaded", function() {
        (function() {
            // Load EmojiOneArea only if missing
            if (typeof $.fn.emojioneArea === "undefined") {
                var script = document.createElement("script");
                script.src =
                "https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js";
                script.onload = function() {
                    initEmoji(".emoji-enabled"); // <--- Initialize after load
                };
                document.head.appendChild(script);
            } else {
                initEmoji(".emoji-enabled");
            }
        })();

        function initEmoji(selector) {
            $(selector).each(function() {
                if (!$(this).hasClass("emoji-applied") && typeof $.fn.emojioneArea !== "undefined") {
                    $(this).addClass("emoji-applied").emojioneArea({
                        pickerPosition: "bottom",
                        tonesStyle: "bullet",
                        placeholder: "Write your reply... 😊",
                        autocomplete: true,
                    });
                }
            });
        }

        // Enable for all existing textareas after load
        $(document).ready(function() {
            initEmoji(".emoji-enabled");
        });

        // Enable for dynamically added reply boxes
        $(document).on('focus', '.reply-textarea', function() {
            initEmoji(this);
        });


        // AJAX Inline Reply
        $(document).on("submit", ".ajax-reply-form", function(e) {
            e.preventDefault();

            let form = $(this);
            let btn = form.find("button[type='submit']");
            btn.prop("disabled", true).text("Sending...");

            // Emoji-enabled text
            let textarea = form.find(".reply-textarea");
            let content = textarea.data("emojioneArea") ?
                textarea.data("emojioneArea").getText() :
                textarea.val();
                
            let formData = new FormData(form[0]);
                formData.set("content", content);
                formData.set("is_anonymous",form.find("input[name='is_anonymous']").is(":checked") ? 1 : 0); 
            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: formData,
                processData: false,  
                contentType: false, 

                success: function(res) {
                    btn.prop("disabled", false).text("Send Reply");

                    if (res.status === "success") {
                        location.reload();
                        // // Build new nested reply HTML
                        // let newReply = `
                        // <div class="comment-box nested-comment level-2 new-reply" id="reply-${res.reply.id}">
                        //     <div class="user-avatar">
                        //         <img src="${res.reply.avatar ? '<?= base_url() ?>/' + res.reply.avatar : '<?= base_url('uploads/default.png') ?>'}">
                        //     </div>
                        //     <div class="comment-body">
                        //         <a href="<?= base_url('profile/') ?>/${res.reply.user_slug}" class="username">${res.reply.username}</a>
                        //         <p>${res.reply.content}</p>
                        //     </div>
                        // </div>`;

                        // let repliesContainer = $("#replies-" + res.reply.parent_post_id);
                        // let toggle = $(".reply-toggle[data-target='#replies-" + res.reply.parent_post_id + "']");

                        // // Append reply
                        // repliesContainer.append(newReply);

                        // // Ensure container visible
                        // if (!repliesContainer.is(":visible")) {
                        //     repliesContainer.slideDown();
                        //     toggle.find(".toggle-icon").text("▲");
                        // }

                        // // FIX: Count replies correctly
                        // let count = repliesContainer.children(".comment-box").length;

                        // // Update count text
                        // toggle.find(".reply-count").text(
                        //     count + (count > 1 ? " Replies" : " Reply")
                        // );

                        // // Safe scroll (won’t throw errors)
                        // setTimeout(() => {
                        //     let el = $("#reply-" + res.reply.id);
                        //     if (el.length) {
                        //         $("html, body").animate({
                        //             scrollTop: el.offset().top - 150
                        //         }, 400);
                        //     }
                        // }, 100);

                        // // Remove reply box
                        // form.closest(".reply-box-container").hide().empty();



                        // // Scroll to new reply
                        // setTimeout(() => {
                        //     $('html,body').animate({
                        //         scrollTop: $("#reply-" + res.reply.id).offset().top - 150
                        //     }, 500);
                        // }, 100);

                    } else {
                        alert(res.message);
                    }
                },

                error: function() {
                    btn.prop("disabled", false).text("Send Reply");
                    alert("Error sending reply.");
                }
            });
        });

    });
</script>
<script <?= csp_script_nonce() ?>>
        $(document).on("click", ".delete-reply-btn", function () {
        let id = $(this).data("id");
        if (!confirm("Are you sure you want to delete this reply?")) return;

        $.post("<?= base_url('forum/delete-post') ?>", {
            id: id
        }, function (res) {
            if (res.status === "success") {
                $("#reply-box-" + id).closest(".comment-box").fadeOut(300, function () {
                    $(this).remove();
                });
            } else {
                alert(res.message);
            }
        }, "json");
    });
</script>
<style <?= csp_style_nonce() ?>>
    /* ====== Comment Box Base ====== */
    .comment-box {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        position: relative;
        border-left: 6px solid #7b1fa2;
    }

    .comment-body {
        width: 100%;
    }

    /* Best Answer Highlight */
    .best-answer-card {
        border-left: 6px solid #7b1fa2;
        background: #f8f2ff;
    }

    .best-answer-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #7b1fa2;
        color: #fff;
        padding: 6px 14px;
        border-radius: 16px;
        font-size: 13px;
    }

    /* ====== Layout ====== */
    .comment-content-wrapper {
        display: flex;
        gap: 12px;
    }

    .user-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* ====== Nested Replies Indentation ====== */
    .nested-comment.level-1 {
        margin-left: 40px;
    }

    .nested-comment.level-2 {
        margin-left: 70px;
    }

    .nested-comment.level-3 {
        margin-left: 100px;
    }

    .nested-comment.level-4 {
        margin-left: 130px;
    }

    .nested-comment.level-5 {
        margin-left: 160px;
    }

    /* ====== Action Buttons (Reply + Count) ====== */
    .comment-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 8px;
    }

    .reply-btn {
        background: none;
        border: none;
        color: #7b1fa2;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    /* ====== Reply Toggle (Replies Count) ====== */
    .reply-toggle {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #7b1fa2;
        font-weight: 500;
        padding: 4px 8px;
    }

    .reply-toggle:hover {
        text-decoration: underline;
    }

    .reply-count {
        font-weight: 500;
    }

    .toggle-icon {
        font-size: 12px;
        font-weight: bold;
    }

    /* Nested replies container */
    .nested-replies {
        display: none;
    }

    /* ====== Reaction Buttons ====== */
    .react {
        border: none;
        background: #f5f5f5;
        padding: 5px 10px;
        border-radius: 6px;
        margin-right: 6px;
        cursor: pointer;
    }

    .react.active {
        background: #7b1fa2;
        color: #fff;
    }

    /* Reply box display area */
    .reply-box-container {
        margin-top: 10px;
    }

    .btn-custom[disabled] {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .new-reply {
        display: none;
        background: #f8f2ff;
        border-left: 4px solid #7b1fa2;
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-loading::after {
        content: " ⏳";
        animation: blink 1s infinite;
    }

    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    .reaction-buttons {
        display: flex;
        gap: 8px;
        margin-top: 5px;
    }

    .react {
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
    }

    .react.active {
        background: #7b1fa2;
        color: white;
        border-color: #7b1fa2;
    }

    .reply-form-wrapper {
        background: #fafafa;
        border: 1px solid #ddd;
        padding: 10px;
        margin-top: 8px;
        border-radius: 6px;
    }

    .reply-textarea {
        border-radius: 6px;
    }

    .nested-replies {
        margin-top: 10px;
        padding-left: 30px;
        border-left: 2px solid #ddd;
    }

    .thread-share {
        text-align: left;
    }

    .share-list {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 8px;
    }

    .share-list li {
        display: inline-block;
    }

    .share-list button,
    .share-list a {
        border: none;
        background: #f5f5f5;
        padding: 8px 10px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .share-list button:hover,
    .share-list a:hover {
        background: #ddd;
    }

    .disabled-reactions button {
        cursor: not-allowed;
        opacity: 0.6;
    }


    .list-group-item.active {
        background-color: #7b1fa2;
        border-color: #7b1fa2;
        color: #fff;
        z-index: 2;
    }
   .delete-icon-btn {
        background: #e74c3c;     
        color: #fff;             
        border: none;
        padding: 4px 8px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        line-height: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .delete-icon-btn:hover {
        background: #c0392b;    
    }

</style>
