<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $audios = get_post_audios($post->id); ?>

<div class="show-on-page-load">
    <div class="post-player">
        <?php if (count($audios) > 0): ?>
            <div class="col-sm-12" id="amplitude-player">
                <div class="row">
                    <div class="columns" id="amplitude-left">
                        <div class="amplitude-inner-left">
                            <img src="<?php echo base_url() . $post->image_slider; ?>" alt="<?php echo $post->title;  ?>"/>
                        </div>
                        <div class="amplitude-inner-right">
                            <div id="player-left-bottom">

                                <div id="meta-container">
                                    <span amplitude-song-info="name" amplitude-main-song-info="true" class="song-name"></span>

                                    <div class="song-artist-album">
                                        <span amplitude-song-info="artist" amplitude-main-song-info="true"></span>
                                    </div>
                                </div>

                                <div id="time-container">
								<span class="current-time">
									<span class="amplitude-current-minutes" amplitude-main-current-minutes="true"></span>:<span class="amplitude-current-seconds" amplitude-main-current-seconds="true"></span>
								</span>
                                    <input type="range" class="amplitude-song-slider" amplitude-main-song-slider="true" step=".1"/>
                                    <span class="duration">
									<span class="amplitude-duration-minutes" amplitude-main-duration-minutes="true"></span>:<span class="amplitude-duration-seconds" amplitude-main-duration-seconds="true"></span>
								</span>
                                </div>

                                <div id="control-container">
                                    <div id="repeat-container">
                                        <div id="repeat" class="amplitude-repeat amplitude-repeat-off"></div>
                                    </div>
                                    <div id="shuffle-container">
                                        <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
                                    </div>

                                    <div id="central-control-container">
                                        <div id="central-controls">
                                            <div class="amplitude-prev" id="previous"></div>
                                            <div class="amplitude-play-pause" amplitude-main-play-pause="true" id="play-pause"></div>
                                            <div class="amplitude-next" id="next"></div>
                                        </div>
                                    </div>

                                    <div id="volume-container">
                                        <div class="volume-controls">
                                            <div class="amplitude-mute amplitude-not-muted"></div>
                                            <input class="amplitude-volume-slider" type="range">
                                        </div>

                                    </div>


                                </div>
                            </div>

                            <div class="columns" id="amplitude-right">

                                <?php $index = 0; ?>
                                <?php foreach ($audios as $audio): ?>

                                    <div class="list-row">
                                        <div class="list-left">
                                            <div class="song amplitude-song-container amplitude-play-pause" amplitude-song-index="<?php echo $index; ?>">
                                                <div class="song-now-playing-icon-container">
                                                    <div class="play-button-container">

                                                    </div>
                                                    <img class="now-playing" src="<?php echo base_url(); ?>assets/vendor/audio-player/img/now-playing.svg"/>
                                                </div>
                                                <div class="song-meta-data">
                                                    <span class="song-title"><?php echo html_escape($audio->audio_name); ?></span>
                                                    <span class="song-artist"><?php echo html_escape($audio->musician); ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="list-right">
                                            <div class="download-link-cnt">
                                                <?php if ($audio->download_button == 1): ?>

                                                    <?php echo form_open('home_controller/download_audio'); ?>
                                                    <input type="hidden" name="audio_id" value="<?php echo $audio->audio_id; ?>">
                                                    <button type="submit" class="download-link">
                                                        <i class="icon-download"></i>&nbsp;<?php echo trans('download'); ?>
                                                    </button>
                                                    <?php echo form_close(); ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php $index++; ?>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>




