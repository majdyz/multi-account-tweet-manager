<?php

namespace Media\Controllers;

use \App;
use \View;
use \Menu;
use \Admin\BaseController;
use Abraham\TwitterOAuth\TwitterOAuth;
use \Media;
use \TweetMedia;
use \TwitterAccount;
use \User;
use \Response;

class MediaController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        Menu::get('admin_sidebar')->setActiveMenu('media');
    }

    public function index()
    {
        $this->data['title'] = 'Media';
        $this->data['medias'] = User::find(\Sentry::getUser()->id)->medias()->get();
        View::display('@media/media/index.twig', $this->data);
    }

    public function upload()
    {
        $base64 = str_replace(' ', '+', $_POST['base64']);
        $file = Media::upload($base64);
        $media = new Media;
        $media->name = $_POST['name'];
        $media->media_id = $file->media_id;
        $media->media_id_string = $file->media_id_string;
        $media->size = $file->size;
        $media->w = $file->w;
        $media->h = $file->h;
        $media->expires_after_secs = $file->expires_after_secs;
        $media->image_type = $file->image_type;
        $media->user_id = \Sentry::getUser()->id;
        $media->save();
        Response::redirect($this->siteUrl('admin/media/' . $media->id));
    }

    public function show($id)
    {
        $this->findMedia($id)->isUserHas();

        $this->data['model'] = $this->findMedia($id);
        $this->data['title'] = 'View ' . $this->data['model']->name;
        View::display('@media/media/view.twig', $this->data);
    }

    public function create()
    {
        $this->loadJs('app/upload.js');
        $this->data['title'] = 'Upload Media';
        View::display('@media/media/create.twig', $this->data);
    }

    public function destroy($id)
    {
        $this->findMedia($id)->isUserHas();

        $this->findMedia($id)->delete();
        Response::redirect($this->siteUrl('admin/media'));
    }

    protected function findMedia($id)
    {
        if (($model = Media::find($id)) != null) {
            return $model;
        }
        App::notFound();
    }
}