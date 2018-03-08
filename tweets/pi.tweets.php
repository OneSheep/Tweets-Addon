<?php  

namespace CAP\Tweets;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tweets {

    const MESSAGE_NO_TWEETS = "";
    const MESSAGE_ERROR = "";

    public $return_data;

    protected $template;
    protected $options;
    protected $auth;

    public function __construct()
    {
        $this->template = ee()->TMPL;

        $this->setParams();

        try {
            $tweets = $this->getTweets();
            $variables = $this->template->advanced_conditionals($this->template->tagdata);
            $this->return_data = $this->template->parse_variables($variables, $tweets);

        } catch (\UnexpectedValueException $e) {
            $this->return_data = self::MESSAGE_NO_TWEETS;

        } catch (\Exception $e) {
            $this->return_data = self::MESSAGE_ERROR;
         // $this->return_data = $e->getMessage();

        }


    }

    function setParams()
    {
      // defaults

        $this->options = [
            'screen_name' => 'CAP',
            'count' => 5,
            'trim_user' => 1,
            'exclude_replies' => 1,
            'include_rts' => 0,
        ];

        $this->auth = [
            'oauth_access_token' => '',
            'oauth_access_token_secret' => '',
            'consumer_key' => '',
            'consumer_secret' => '',
        ];

      // overrides

        foreach ($this->options as $key => $value) {
            $provided = $this->template->fetch_param($key);
            if ($provided !== false) $this->options[$key] = $provided;
        }

        foreach ($this->auth as $key => $value) {
            $provided = $this->template->fetch_param($key);
            if ($provided !== false) $this->auth[$key] = $provided;
        }
    }


    function getTweets()
    {

        require_once('TwitterAPIExchange.php');

        $endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $query = '?'.http_build_query($this->options);
        $verb = 'GET';

        $twitter = new TwitterAPIExchange($this->auth);
        $response = $twitter->setGetfield($query)
        ->buildOauth($endpoint, $verb)
        ->performRequest();

        $timeline = json_decode($response);

        if (isset($timeline->errors[0]->code))
        {
            throw new \Exception("Error Code: " . $timeline->errors[0]->message);
        }

        if (empty($response))
        {
            throw new \UnexpectedValueException();
        }

        $i = 0;
        foreach ($timeline as $tweet) {
            $tweet_text = htmlentities($tweet->text, ENT_QUOTES);
            $tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $tweet_text);
            $tweet->text = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $tweet_text);

            $tweet->time_ago = $this->forHumans($tweet->created_at);

            $tweets[$i] = (array)$tweet;

            if ($this->options['trim_user'] == 0)
            {
                foreach($tweets[$i]['user'] as $key => $author)
                {
                    $tweets[$i]["author_$key"] = $author;
                }
            }

            // remove extra meta data
            unset($tweets[$i]['user']);
            unset($tweets[$i]['entities']);
            unset($tweets[$i]['author_entities']);

            $i++;
        }

        return $tweets;

    }

    protected function forHumans($a)   
    {
        $b = strtotime("now");

        $c = strtotime($a);

        $d = $b - $c; 

        $minute = 60;
        $hour = $minute*60;
        $day = $hour*24;
        $week = $day*7;

        if (is_numeric($d) && $d > 0)
        {
            if ($d < 3) return "right now";

            if ($d < $minute) return floor($d) . " seconds ago";

            if ($d < $minute * 2 ) return "about 1 minute ago";

            if($d < $hour) return floor($d / $minute) . " minutes ago";

            if($d < $hour * 2) return "about 1 hour ago";

            if($d < $day) return floor($d / $hour) . " hours ago";

            if($d > $day && $d < $day * 2) return "yesterday";

            if($d < $day * 365) return floor($d / $day) . " days ago";

            return "over a year ago";

        }
    }

    public static function usage()
    {
        return "See https://github.com/OneSheep/Tweets-Addon";   
    }
}


/* End of file pi.tweets.php */
/* Location: system/user/addons/tweets/pi.tweets.php */