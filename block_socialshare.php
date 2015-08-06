<?php
// This file is part of SocialShare - https://github.com/sekharjaji/moodle-block_socialshare
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * SocialShare block class.
 *
 * @package   block_socialshare
 * @copyright 2015 onwards Sekhar Jajimoggala
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_socialshare extends block_base {

    /**
     * Initializes the block
     * Sets up the block title
     */
    public function init() {
        $this->title = get_string('socialshare', 'block_socialshare');
    }

    /**
     * Checks 3 configurations - enablefacebook, enabletwitter, enablegoogleplus and enablestumbleupon
     * And accordingly generate the scripts and html required to display the social buttons
     *
     * @return stdObject Content object to render
     */
    public function get_content() {

        $enablefacebook = false;
        $enabletwitter = false;
        $enablegoogleplus = false;
        $enablestumbleupon = false;

        if (!empty($this->config->enablefacebook)) {
            $enablefacebook = $this->config->enablefacebook;
        }
        if (!empty($this->config->enabletwitter)) {
            $enabletwitter = $this->config->enabletwitter;
        }
        if (!empty($this->config->enablegoogleplus)) {
            $enablegoogleplus = $this->config->enablegoogleplus;
        }
        if (!empty($this->config->enablestumbleupon)) {
            $enablestumbleupon = $this->config->enablestumbleupon;
        }

        if ($this->content != null) {
            return $this->content;
        }

        $url = $this->get_url();

        if ((!$enablefacebook) && (!$enabletwitter) && (!$enablegoogleplus) && (!$enablestumbleupon)) {
            $this->content = null;
            return '';
        }

        $this->init_js_code($enablefacebook, $enabletwitter, $enablestumbleupon);

        $this->content = new stdClass();
        if ($enablefacebook) {
            $facebooklike = $this->get_facebook_like($url);
        }
        if ($enabletwitter) {
            $twittershare = $this->get_twitter_share($url);
        }
        if ($enablegoogleplus) {
            $googleplusshare = $this->get_googleplus_share($url);
        }
        if ($enablestumbleupon) {
            $stumbleuponshare = $this->get_stumbleupon_share($url);
        }

        $this->content->text = '<ul class="vertical"><li id="facebook-like">'.
                                $facebooklike.'</li><li id="twitter-share">'.
                                $twittershare.'</li><li id="googleplus-share">'.
                                $googleplusshare.'</li><li id="stumbleupon-share">'.
                                $stumbleuponshare.'</li></ul>';
    }

    /**
     * Do not allow multiple instances
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Generate scripts required for facebook and twitter buttons
     *
     * @param $enablefacebook
     * @param $enabletwitter
     * @param $enablestumbleupon
     */
    private function init_js_code($enablefacebook, $enabletwitter, $enablestumbleupon) {
        if ($enablefacebook) {
            $this->page->requires->js_init_code('(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, "script", "facebook-jssdk"));');
        }
        if ($enabletwitter) {
            $this->page->requires->js_init_code("!function(d,s,id){
                var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                if(!d.getElementById(id)){
                    js=d.createElement(s);
                    js.id=id;
                    js.src=p+'://platform.twitter.com/widgets.js';
                    fjs.parentNode.insertBefore(js,fjs);
                }
            }(document, 'script', 'twitter-wjs');");
        }
        if ($enablestumbleupon) {
            $this->page->requires->js_init_code("(function() {
                var li = document.createElement('script');
                li.type = 'text/javascript';
                li.async = true;
                li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(li, s);
            })();");
        }
    }

    /**
     * Generates html for facebook button
     *
     * @param $url
     * @return string
     */
    private function get_facebook_like($url) {
        return '<div id="fb-root"></div><div class="fb-like" data-href="'.
                $url.'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" data-width="30">'.
                '</div>';
    }

    /**
     * Generates html for twitter button
     *
     * @param $url
     * @return string
     */
    private function get_twitter_share($url) {
        return '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'">Tweet</a>';
    }

    /**
     * Generates html for googleplus button
     *
     * @param $url
     * @return string
     */
    private function get_googleplus_share($url) {
        return '<script src="https://apis.google.com/js/platform.js" async defer></script>'.
                '<div class="g-plus" data-action="share" data-annotation="bubble" data-height="24" data-href="'.$url.'"></div>';
    }

    /**
     * Generates html for stumbleupon button
     *
     * @param $url
     * @return string
     */
    private function get_stumbleupon_share($url) {
        return '<su:badge layout="2" location="'.$url.'"></su:badge>';
    }

    /**
     * Returns url to set for social buttons based on the url scope configuration
     *
     * @return moodle_url|string
     */
    public function get_url() {
        global $CFG;

        if (!empty($this->config->urlscope)) {
            switch ($this->config->urlscope) {
                case 4 : $url = $this->get_mod_url();
                    break;
                case 3 : $url = $this->get_course_url();
                    break;
                case 2 : $url = new moodle_url($CFG->wwwroot);
                    break;
                case 1 :
                default : $url = $this->page->url;
                    break;
            }
        } else {
            return '';
        }
        $url = $url->out(true);

        return $url;
    }

    /**
     * Return course url, which current page belongs to.
     *
     * @return moodle_url
     */
    public function get_course_url() {
        $context = $this->context->get_course_context();
        return $url = new moodle_url($context->get_url());
    }

    /**
     * Return mod url, which current page belongs to.
     *
     * @return moodle_url
     */
    public function get_mod_url() {
        // Context of the page holding the block.
        $context = $this->page->context;
        return $url = new moodle_url($context->get_url());
    }

}