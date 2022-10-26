<?php $__env->startSection('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i>
        <?php echo e(__('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular); ?>

    </h1>
    <?php echo $__env->make('voyager::multilingual.language-selector', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="<?php if(isset($dataTypeContent->id)): ?><?php echo e(route('voyager.posts.update', $dataTypeContent->id)); ?><?php else: ?><?php echo e(route('voyager.posts.store')); ?><?php endif; ?>" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            <?php if(isset($dataTypeContent->id)): ?>
                <?php echo e(method_field("PUT")); ?>

            <?php endif; ?>
            <?php echo e(csrf_field()); ?>


            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <?php if(count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> <?php echo e(__('voyager::post.title')); ?>

                                <span class="panel-desc"> <?php echo e(__('voyager::post.title_sub')); ?></span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'title',
                                '_field_trans' => get_field_translations($dataTypeContent, 'title')
                            ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <input type="text" class="form-control" id="title" name="title" placeholder="<?php echo e(__('voyager::generic.title')); ?>" value="<?php if(isset($dataTypeContent->title)): ?><?php echo e($dataTypeContent->title); ?><?php endif; ?>">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(__('voyager::post.content')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <?php echo $__env->make('voyager::multilingual.input-hidden', [
                            '_field_name'  => 'body',
                            '_field_trans' => get_field_translations($dataTypeContent, 'body')
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php
                            $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            $row = $dataTypeRows->where('field', 'body')->first();
                        ?>

                        <div class="panel-body">
                            <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                        </div>
                    </div><!-- .panel -->

                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __('voyager::post.excerpt'); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'excerpt',
                                '_field_trans' => get_field_translations($dataTypeContent, 'excerpt')
                            ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <textarea class="form-control" name="excerpt"><?php if(isset($dataTypeContent->excerpt)): ?><?php echo e($dataTypeContent->excerpt); ?><?php endif; ?></textarea>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(__('voyager::post.additional_fields')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $exclude = ['title', 'body', 'excerpt', 'slug', 'status', 'category_id', 'author_id', 'featured', 'image', 'meta_description', 'meta_keywords', 'seo_title'];
                            ?>

                            <?php $__currentLoopData = $dataTypeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!in_array($row->field, $exclude)): ?>
                                    <?php
                                        $options = json_decode($row->details);
                                        $display_options = isset($options->display) ? $options->display : NULL;
                                    ?>
                                    <?php if($options && isset($options->formfields_custom)): ?>
                                        <?php echo $__env->make('voyager::formfields.custom.' . $options->formfields_custom, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php else: ?>
                                        <div class="form-group <?php if($row->type == 'hidden'): ?> hidden <?php endif; ?> <?php if(isset($display_options->width)): ?><?php echo e('col-md-' . $display_options->width); ?><?php endif; ?>" <?php if(isset($display_options->id)): ?><?php echo e("id=$display_options->id"); ?><?php endif; ?>>
                                            <?php echo e($row->slugify); ?>

                                            <label for="name"><?php echo e($row->display_name); ?></label>
                                            <?php echo $__env->make('voyager::multilingual.input-hidden-bread-edit-add', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php if($row->type == 'relationship'): ?>
                                                <?php echo $__env->make('voyager::formfields.relationship', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php else: ?>
                                                <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                                            <?php endif; ?>

                                            <?php $__currentLoopData = app('voyager')->afterFormFields($row, $dataType, $dataTypeContent); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $after): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $after->handle($row, $dataType, $dataTypeContent); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> <?php echo e(__('voyager::post.details')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="slug"><?php echo e(__('voyager::post.slug')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="slug"
                                    {<?php echo isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug"); ?>}
                                    value="<?php if(isset($dataTypeContent->slug)): ?><?php echo e($dataTypeContent->slug); ?><?php endif; ?>">
                            </div>
                            <div class="form-group">
                                <label for="status"><?php echo e(__('voyager::post.status')); ?></label>
                                <select class="form-control" name="status">
                                    <option value="PUBLISHED"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PUBLISHED'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_published')); ?></option>
                                    <option value="DRAFT"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'DRAFT'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_draft')); ?></option>
                                    <option value="PENDING"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PENDING'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_pending')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id"><?php echo e(__('voyager::post.category')); ?></label>
                                <select class="form-control" name="category_id">
                                    <?php $__currentLoopData = TCG\Voyager\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"<?php if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id): ?> selected="selected"<?php endif; ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="featured"><?php echo e(__('voyager::generic.featured')); ?></label>
                                <input type="checkbox" name="featured"<?php if(isset($dataTypeContent->featured) && $dataTypeContent->featured): ?> checked="checked"<?php endif; ?>>
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> <?php echo e(__('voyager::post.image')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php if(isset($dataTypeContent->image)): ?>
                                <img src="<?php echo e(filter_var($dataTypeContent->image, FILTER_VALIDATE_URL) ? $dataTypeContent->image : Voyager::image( $dataTypeContent->image )); ?>" style="width:100%" />
                            <?php endif; ?>
                            <input type="file" name="image">
                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> <?php echo e(__('voyager::post.seo_content')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="meta_description"><?php echo e(__('voyager::post.meta_description')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_description',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_description')
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <textarea class="form-control" name="meta_description"><?php if(isset($dataTypeContent->meta_description)): ?><?php echo e($dataTypeContent->meta_description); ?><?php endif; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords"><?php echo e(__('voyager::post.meta_keywords')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_keywords',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_keywords')
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <textarea class="form-control" name="meta_keywords"><?php if(isset($dataTypeContent->meta_keywords)): ?><?php echo e($dataTypeContent->meta_keywords); ?><?php endif; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="seo_title"><?php echo e(__('voyager::post.seo_title')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'seo_title',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'seo_title')
                                ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <input type="text" class="form-control" name="seo_title" placeholder="SEO Title" value="<?php if(isset($dataTypeContent->seo_title)): ?><?php echo e($dataTypeContent->seo_title); ?><?php endif; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                <?php if(isset($dataTypeContent->id)): ?><?php echo e(__('voyager::post.update')); ?><?php else: ?> <i class="icon wb-plus-circle"></i> <?php echo e(__('voyager::post.new')); ?> <?php endif; ?>
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="<?php echo e(route('voyager.upload')); ?>" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            <?php echo e(csrf_field()); ?>

            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="<?php echo e($dataType->slug); ?>">
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

        <?php if($isModelTranslatable): ?>
            $('.side-body').multilingual({"editing": true});
        <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>