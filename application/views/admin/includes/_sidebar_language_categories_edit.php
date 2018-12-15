<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('category'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label><?php echo trans("language"); ?></label>
            <select name="lang_id" class="form-control" onchange="get_top_categories_by_lang(this.value);">
                <?php foreach ($languages as $language): ?>
                    <option value="<?php echo $language->id; ?>" <?php echo ($post->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo trans('category'); ?></label>
            <select id="categories" name="category_id" class="form-control" onchange="get_sub_categories(this.value);" required>
                <option value=""><?php echo trans('select_category'); ?></option>
                <?php foreach ($categories as $item): ?>
                    <?php if ($item->id == $post->category_id): ?>
                        <option value="<?php echo html_escape($item->id); ?>" selected><?php echo html_escape($item->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo trans('subcategory'); ?></label>
            <select id="subcategories" name="subcategory_id" class="form-control">
                <option value="0"><?php echo trans('select_category'); ?></option>

                <?php foreach ($subcategories as $item): ?>
                    <?php if ($item->id == $post->subcategory_id): ?>
                        <option value="<?php echo html_escape($item->id); ?>" selected><?php echo html_escape($item->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>





