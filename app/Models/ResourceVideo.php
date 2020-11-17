<?php

namespace App\Models;
use AliCloud\Core\Profile\DefaultProfile;
use AliCloud\Core\DefaultAcsClient;
use AliCloud\Vod\GetPlayInfoRequest;
use AliCloud\Vod\GetVideoInfoRequest;
use AliCloud\Vod\GetVideoPlayAuthRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceVideo extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['resource_id', 'ali_id'];

    //获取playinfo
    public function getPlayInfoAttribute()
    {
        //使用
        $access_key_id = setting('ali_access');
        $access_key_secret = setting("ali_secret");
        $region_id = setting('ali_region');

        try {
            $profile = DefaultProfile::getProfile($region_id, $access_key_id, $access_key_secret);

            $client = new DefaultAcsClient($profile);

            $videoId = $this->ali_id;
            $req = new GetPlayInfoRequest();
            $req->setVideoId($videoId);
            $req->setAcceptFormat("JSON");
            $response = $client->getAcsResponse($req);
            $list = collect($response->PlayInfoList->PlayInfo)->keyBy('Format');
        } catch (Exception $e) {
            exit($e);
        }
        return $list;
    }

    //获取palyauth
    public function getPlayAuthAttribute()
    {
        //使用
        $access_key_id = setting('ali_access');
        $access_key_secret = setting("ali_secret");
        $region_id = setting('ali_region');

        try {
            $profile = DefaultProfile::getProfile($region_id, $access_key_id, $access_key_secret);

            $client = new DefaultAcsClient($profile);

            $videoId = $this->ali_id;
            $req = new GetVideoPlayAuthRequest();
            $req->setVideoId($videoId);
            $req->setAcceptFormat("JSON");
            $response = $client->getAcsResponse($req);
        } catch (Exception $e) {
            exit($e);
        }
        return $response;
    }
}
