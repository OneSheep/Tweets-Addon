## Tweets

An ExpressionEngine addon to pull in the latest tweets for any configured Twitter account.

### Installation

Drop the tweets folder in your app's system/user/addons directory

### Usage

Example:

    {exp:tweets
        oauth_access_token="xxxxx" <!--required-->
        oauth_access_token_secret="xxxxx" <!--required-->
        consumer_key="xxxxx" <!--required-->
        consumer_secret="xxxxx" <!--required-->
        screen_name="adpearance" <!--optional-->
        count="3" <!--optional-->
        trim_user="1" <!--optional-->
        exclude_replies="1" <!--optional-->
        contributor_details="0" <!--optional-->
        include_rts="0" <!--optional-->
    }
          <h3>{time_ago}</h3>
          <div>{text}</div>

    {/exp:tweets}


### Parameters

`oauth_access_token`
`oauth_access_token_secret`
`consumer_key`
`consumer_secret`

Required. Copy these from your Twitter application. If you do not have an application yet, you can quickly create one by signing in at https://developer.twitter.com/

`screen_name`

Optional. The screen name of the user for whom to return results.

`count`

Optional. Specifies the number of Tweets to try and retrieve, up to a maximum of 200 per distinct request. The value of count is best thought of as a limit to the number of Tweets to return because suspended or deleted content is removed after the count has been applied. We include retweets in the count, even if `include_rts` is not supplied. It is recommended you always send `include_rts=1` when using this parameter.


`trim_user`

Optional. When set to either `true`, `t` or `1`, each Tweet returned in a timeline will include a user object including only the status authors numerical ID. Omit this parameter to receive the complete user object.

`exclude_replies`

Optional. This parameter will prevent replies from appearing in the returned timeline. Using exclude_replies with the count parameter will mean you will receive up-to `count` tweets — this is because the count parameter retrieves that many Tweets before filtering out retweets and replies.

`include_rts`

Optional. When set to false, the timeline will strip any native retweets (though they will still count toward both the maximal length of the timeline and the slice selected by the count parameter). Note: If you’re using the trim_user parameter in conjunction with include_rts, the retweets will still contain a full user object.



### Tags available in your template for each tweet

{created_at}
{time_ago}
{text}
{retweet_count}
{favorite_count}
{truncated}
{coordinates}
{source}
{id}
{id_str}
{in_reply_to_status_id}
{in_reply_to_status_id_str}
{in_reply_to_user_id}
{in_reply_to_user_id_str}
{in_reply_to_screen_name}
{geo}
{place}
{contributors}
{favorited}
{retweeted}
{possibly_sensitive}
{lang}
{author_id}
{author_id_str}
{author_name}
{author_screen_name}
{author_location}
{author_description}
{author_url}
{author_protected}
{author_followers_count}
{author_friends_count}
{author_listed_count}
{author_created_at}
{author_favourites_count}
{author_utc_offset}
{author_time_zone}
{author_geo_enabled}
{author_verified}
{author_statuses_count}
{author_lang}
{author_contributors_enabled}
{author_is_translator}
{author_profile_background_color}
{author_profile_background_image_url}
{author_profile_background_image_url_https}
{author_profile_background_tile}
{author_profile_image_url}
{author_profile_image_url_https}
{author_profile_banner_url}
{author_profile_link_color}
{author_profile_sidebar_border_color}
{author_profile_sidebar_fill_color}
{author_profile_text_color}
{author_profile_use_background_image}
{author_default_profile}
{author_default_profile_image}
{author_following}
{author_follow_request_sent}
{author_notifications}

For more information about the optional parameters or the returned tags see the [Twitter API documentation](https://developer.twitter.com/en/docs/tweets/timelines/api-reference/get-statuses-user_timeline.html)

### EE Version Support

ExpressionEngine 3+

### Acknowledgement

The plugin uses J7mbo's [PHP Wrapper for Twitter API v1.1 calls](http://github.com/j7mbo/twitter-api-php)

Idea for this plugin comes from Adpearance's [Twitter Recent Tweets](https://devot-ee.com/add-ons/twitter-recent-tweets)
