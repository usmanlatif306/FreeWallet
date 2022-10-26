<?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old(
    $row->field,
                $dataTypeContent->{$row->field}
))) ? old(
                    $row->field,
        $dataTypeContent->{$row->field}
                ) : old($row->field); ?>
                                        <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
<ul class="radio">
    <?php if(isset($options->options)): ?>
        <?php $__currentLoopData = $options->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <input type="radio" id="option-<?php echo e(str_slug($row->field, '-')); ?>-<?php echo e(str_slug($key, '-')); ?>"
                       name="<?php echo e($row->field); ?>"
                       value="<?php echo e($key); ?>" <?php if($default == $key && $selected_value === NULL): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($selected_value == $key): ?><?php echo e('checked'); ?><?php endif; ?>>
                <label for="option-<?php echo e(str_slug($row->field, '-')); ?>-<?php echo e(str_slug($key, '-')); ?>"><?php echo e($option); ?></label>
                <div class="check"></div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</ul>
