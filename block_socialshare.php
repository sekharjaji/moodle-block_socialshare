<?php
/**
 * socialshare block class.
 *
 * @package   block_socialshare
 * @copyright 2015 onwards Sekhar Jajimoggala
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_socialshare extends block_base {
    public function init() {
        $this->title = get_string('socialshare', 'block_socialshare');
    }

    public function get_content(){

        $enableFacebook = $this->config->enablefacebook;
        $enableTwitter = $this->config->enabletwitter;
        $enableGooglePlus = $this->config->enablegoogleplus;

        if ($this->content != null){
            return $this->content;
        }

        $url = $this->get_url();

        if ((!$enableFacebook) && (!$enableTwitter) && (!$enableGooglePlus)){
            $this->content = null;
            return '';
        }

        $this->init_js_code($enableFacebook, $enableTwitter, $enableGooglePlus);

        $this->content = new stdClass();
        if ($enableFacebook){
            $facebook_like = $this->get_facebook_like($url);
        }
        if ($enableTwitter){
            $twitter_share = $this->get_twitter_share($url);
        }
        if ($enableGooglePlus){
            $googleplus_share = $this->get_googleplus_share($url);
        }

        $this->content->text = '<ul class="vertical"><li id="facebook-like">'.$facebook_like.'</li><li id="twitter-share">'.$twitter_share.'</li><li id="googleplus-share">'.$googleplus_share.'</li></ul>';
    }

    public function instance_allow_multiple() {
        return false;
    }

    private function init_js_code($enableFacebook, $enableTwitter, $enableGooglePlus){
        if ($enableFacebook){
            $this->page->requires->js_init_code('(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, "script", "facebook-jssdk"));');
        }
        if ($enableTwitter){
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
    }

    private function get_facebook_like($url){
        return '<div id="fb-root"></div><div class="fb-like" data-href="'.$url.'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" data-width="30"></div>';
    }

    private function get_twitter_share($url){
        return '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'">Tweet</a>';
    }

    private function get_googleplus_share($url){
        return '<script src="https://apis.google.com/js/platform.js" async defer></script><div class="g-plus" data-action="share" data-annotation="bubble" data-height="24" data-href="'.$url.'"></div>';
    }

    public function get_url(){
        global $CFG;

        if (!empty($this->config->urltype)) {
            switch ($this->config->urltype) {
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