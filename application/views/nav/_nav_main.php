<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="navbar navbar-default main-menu megamenu">
    <div class="container">
        <?php $menu_limit = $general_settings->menu_limit - 1; ?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <div class="row">
                <ul class="nav navbar-nav">
                    <li class="<?php echo (uri_string() == 'index' || uri_string() == "") ? 'active' : ''; ?>">
                        <a href="<?php echo lang_base_url(); ?>">
                            <?php echo trans("home"); ?>
                        </a>
                    </li>
                    <?php $total_item = 0;
                    $menu_item_count = 1; ?>
                    <?php if (!empty($this->menu_links)):
                        foreach ($this->menu_links as $item):
                            if ($item['visibility'] == 1 && $item['lang_id'] == $this->language_id && $item['location'] == "main" && $item['parent_id'] == "0"):
                                if ($menu_item_count <= $menu_limit):
                                    $sub_links = helper_get_sub_menu_links($item['id'], $item['type']);
                                    if ($item['type'] == "category") {
                                        if (!empty($sub_links)) {
                                            $this->load->view('nav/_megamenu_multicategory', ['item_id' => $item['id']]);
                                        } else {
                                            $this->load->view('nav/_megamenu_singlecategory', ['item_id' => $item['id']]);
                                        }
                                    } else {
                                        if (!empty($sub_links)): ?>
                                            <li class="dropdown <?php echo (uri_string() == 'category/' . $item['slug'] ||
                                                uri_string() == $item['slug']) ? 'active' : ''; ?>">
                                                <a class="dropdown-toggle disabled no-after" data-toggle="dropdown"
                                                   href="<?php echo $item['link']; ?>">
                                                    <?php echo html_escape($item['title']); ?>
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-more dropdown-top">
                                                    <?php foreach ($sub_links as $sub_item): ?>
                                                        <?php if ($sub_item["visibility"] == 1): ?>
                                                            <li>
                                                                <a role="menuitem" href="<?php echo $sub_item['link']; ?>">
                                                                    <?php echo html_escape($sub_item['title']); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li class="<?php echo (uri_string() == 'category/' . $item['slug'] ||
                                                uri_string() == $item['slug']) ? 'active' : ''; ?>">
                                                <a href="<?php echo $item['link']; ?>">
                                                    <?php echo html_escape($item['title']); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    }
                                    $menu_item_count++;
                                endif;
                                $total_item++;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($total_item > $menu_limit): ?>
                        <li class="dropdown relative">
                            <a class="dropdown-toggle dropdown-more-icon" data-toggle="dropdown" href="#">
                                <i class="icon-ellipsis-h"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-more dropdown-top">
                                <?php $menu_item_count = 1;
                                if (!empty($this->menu_links)):
                                    foreach ($this->menu_links as $item):
                                        if ($item['visibility'] == 1 && $item['lang_id'] == $this->language_id && $item['location'] == "main" && $item['parent_id'] == "0"):
                                            if ($menu_item_count > $menu_limit):
                                                $sub_links = helper_get_sub_menu_links($item['id'], $item['type']);
                                                if (!empty($sub_links)): ?>
                                                    <li class="dropdown-more-item">
                                                        <a class="dropdown-toggle disabled" data-toggle="dropdown" href="<?php echo $item['link']; ?>">
                                                            <?php echo html_escape($item['title']); ?> <span class="icon-arrow-right"></span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-sub">
                                                            <?php foreach ($sub_links as $sub_item): ?>
                                                                <?php if ($sub_item["visibility"] == 1): ?>
                                                                    <li>
                                                                        <a role="menuitem"
                                                                           href="<?php echo $sub_item['link']; ?>">
                                                                            <?php echo html_escape($sub_item['title']); ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a href="<?php echo $item['link']; ?>">
                                                            <?php echo html_escape($item['title']); ?>
                                                        </a>
                                                    </li>
                                                <?php endif;
                                            endif;
                                            $menu_item_count++;
                                        endif;
                                    endforeach;
                                endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="li-search">
                        <a class="search-icon"><i class="icon-search"></i></a>
                        <div class="search-form">
                            <?php echo form_open(lang_base_url() . 'search', ['method' => 'get', 'id' => 'search_validate']); ?>
                            <input type="text" name="q" maxlength="300" pattern=".*\S+.*" class="form-control form-input" placeholder="<?php echo trans("placeholder_search"); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            <button class="btn btn-default"><i class="icon-search"></i></button>
                            <?php echo form_close(); ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>