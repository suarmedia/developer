<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($ad_space)): ?>

    <?php $ad_codes = helper_get_ad_codes($ad_space); ?>

    <?php if (!empty($ad_codes)): ?>

        <?php if ($ad_space == "sidebar_top" || $ad_space == "sidebar_bottom"): ?>

            <?php if (trim($ad_codes->ad_code_300) != ''): ?>
                <div class="col-sm-12 col-xs-12 bn-lg-sidebar <?php echo(isset($class) ? $class : ''); ?>">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_300; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <?php if (trim($ad_codes->ad_code_728) != '') : ?>
                <section class="col-sm-12 col-xs-12 bn-lg <?php echo(isset($class) ? $class : ''); ?>">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_728; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (trim($ad_codes->ad_code_468) != ''): ?>
                <section class="col-sm-12 col-xs-12 bn-md <?php echo(isset($class) ? $class : ''); ?>">
                    <div class="row">
                        <?php echo $ad_codes->ad_code_468; ?>
                    </div>
                </section>
            <?php endif; ?>

        <?php endif; ?>


        <?php if (trim($ad_codes->ad_code_234) != ''): ?>
            <section class="col-sm-12 col-xs-12 bn-sm <?php echo(isset($class) ? $class : ''); ?>">
                <div class="row">
                    <?php echo $ad_codes->ad_code_234; ?>
                </div>
            </section>
        <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>


