<?php namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use mattiasdelang\Bierdopje;

class ApiController extends Controller {

  /** @var  Bierdopje */
  protected $api;

  public function __construct()
  {
    $this->api        = app()->make('BierdopjeApi');
  }

  public function getShowById($showId)
  {
    $show = $this->api->getShowById($showId);
    $show = $this->formatShow($show);

    return JsonResponse::create($show);
  }

  public function getShowByName($showName)
  {
    if ( is_numeric($showName) )
      return $this->getShowById($showName);

    $show = $this->api->getShowByName($showName);
    $show = $this->formatShow($show);

    return JsonResponse::create($show);
  }

  public function getShowByTVDBID($tvdbId)
  {
    if ( ! is_numeric($tvdbId) )
      return [];

    $show = $this->api->getShowByTvdbId($tvdbId);
    $show = $this->formatShow($show);

    return JsonResponse::create($show);
  }

  public function getEpisodesForSeason($showId, $season)
  {
    if ( ! is_numeric($showId) || ! is_numeric($season) )
      return [];

    $episodes = $this->api->getEpisodesOfSeason($showId, $season);
    $episodes = $this->formatEpisodes($episodes);

    return JsonResponse::create($episodes);
  }

  public function getEpisodeById($episodeId)
  {
    if ( ! is_numeric($episodeId) )
      return [];

    $episode = $this->api->getEpisodeById($episodeId);
    $episode = $this->formatEpisode($episode);

    return JsonResponse::create($episode);
  }

  public function getAllEpisodesForShow($showId)
  {
    if ( ! is_numeric($showId) )
      return [];

    $episodes = $this->api->getEpisodesOfShow($showId);
    $episodes = $this->formatEpisodes($episodes);

    return JsonResponse::create($episodes);
  }

  private function formatShow($show)
  {
    if ( ! $show )
      return null;

    $show->firstAired  = $this->formatDate($show->firstAired);
    $show->lastAired   = $this->formatDate($show->lastAired);
    $show->nextEpisode = $this->formatDate($show->nextEpisode);

    return $show;
  }

  private function formatDate($date, $format = 'd-m-Y')
  {
    if ( $date )
      $date = $date->format($format);

    return $date;
  }

  private function formatEpisode($episode)
  {
    if ( ! $episode )
      return null;

    $episode->airDate = $this->formatDate($episode->airDate);

    return $episode;
  }

  private function formatEpisodes($episodes)
  {
    if ( ! $episodes )
      return null;

    $tmp = [];
    foreach ( $episodes as $k => $episode )
      $tmp[$k] = $this->formatEpisode($episode);

    return $tmp;
  }

}