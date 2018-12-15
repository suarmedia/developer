<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Check if has subcategory-->
<?php if (is_category_has_subcategory($category->id)): ?>
    <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . html_escape($category->id); ?>" class="nav nav-tabs pull-right sub-block-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#all-<?php echo html_escape($category->id); ?>" role="tab" data-toggle="tab"><?php echo trans("all"); ?></a></li>
        <?php $subcategories = helper_get_subcategories($category->id); ?>
        <?php $sub_count = 1; ?>
        <?php foreach ($subcategories as $subcategory): ?>
            <?php if ($sub_count < 5): ?>
                <li role="presentation">
                    <a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" role="tab" data-toggle="tab">
                        <?php echo html_escape($subcategory->name); ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php $sub_count++; ?>
        <?php endforeach; ?>
        <?php if (count($subcategories) >= 5): ?>
            <li>
                <a href="javascript:void(0)" class="dropdown-toggle btn-block-more" type="button" data-toggle="dropdown">
                    <span class="icon-ellipsis-h more subcategories-more-icon"></span>
                </a>
                <div class="dropdown-menu sub-block-dropdown pull-right">
                    <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . html_escape($category->id); ?>" class="nav nav-tabs pull-right" role="tablist">
                        <?php $sub_count = 1; ?>
                        <?php foreach (helper_get_subcategories($category->id) as $subcategory): ?>
                            <?php if ($sub_count >= 5): ?>
                                <li role="presentation">
                                    <a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" role="tab" data-toggle="tab">
                                        <?php echo html_escape($subcategory->name); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php $sub_count++; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ul>
    <div class="sub-block-tabs-mobile">
        <a href="javascript:void(0)" class="dropdown-toggle btn-block-more" type="button" data-toggle="dropdown">
            <span class="icon-ellipsis-h more subcategories-more-icon"></span>
            <span class="caret"></span>
        </a>
        <div class="dropdown-menu sub-block-dropdown pull-right">
            <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . html_escape($category->id); ?>" class="nav nav-tabs pull-right" role="tablist">
                <li role="presentation" class="active"><a href="#all-<?php echo html_escape($category->id); ?>" role="tab" data-toggle="tab"><?php echo trans("all"); ?></a></li>

                <?php foreach (helper_get_subcategories($category->id) as $subcategory): ?>
                    <li role="presentation"><a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" role="tab"
                                               data-toggle="tab"><?php echo html_escape($subcategory->name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>



