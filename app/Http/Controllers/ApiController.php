<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use mattiasdelang\Bierdopje;

class ApiController extends Controller {

  /** @var  Bierdopje */
  protected $api;

  /** @var  Filesystem */
  protected $filesystem;

  protected $ttl;

  public function __construct(Filesystem $filesystem)
  {
    $this->api        = app()->make('BierdopjeApi');
    $this->filesystem = $filesystem;
    $this->ttl        = 60 * 60 * 24; // 24h

    $this->middleware('cors');
  }

  public function getShowById($showId)
  {
    $show = $this->api->getShowById($showId);
    $show = $this->formatShow($show);

    return JsonResponse::create($show)->setTtl($this->ttl);
  }

  public function getShowByName($showName)
  {
    if ( is_numeric($showName) )
      return $this->getShowById($showName);

    $show = $this->api->getShowByName($showName);
    $show = $this->formatShow($show);

    return JsonResponse::create($show)->setTtl($this->ttl);
  }

  public function getShowByTVDBID($tvdbId)
  {
    if ( ! is_numeric($tvdbId) )
      return [];

    $show = $this->api->getShowByTvdbId($tvdbId);
    $show = $this->formatShow($show);

    return JsonResponse::create($show)->setTtl($this->ttl);
  }

  public function getEpisodesForSeason($showId, $season)
  {
    if ( ! is_numeric($showId) || ! is_numeric($season) )
      return [];

    $episodes = $this->api->getEpisodesOfSeason($showId, $season);
    $episodes = $this->formatEpisodes($episodes);

    return JsonResponse::create($episodes)->setTtl($this->ttl);
  }

  public function getEpisodeById($episodeId)
  {
    if ( ! is_numeric($episodeId) )
      return [];

    $episode = $this->api->getEpisodeById($episodeId);
    $episode = $this->formatEpisode($episode);

    return JsonResponse::create($episode)->setTtl($this->ttl);
  }

  public function getAllEpisodesForShow($showId)
  {
    if ( ! is_numeric($showId) )
      return [];

    $episodes = $this->api->getEpisodesOfShow($showId);
    $episodes = $this->formatEpisodes($episodes);

    return JsonResponse::create($episodes)->setTtl($this->ttl);
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