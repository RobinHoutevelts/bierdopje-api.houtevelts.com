<?php
Route::get('/', function () {
  return redirect('http://www.bierdopje.com');
});

Route::get('/GetShowByName/{showName}', 'ApiController@getShowByName');
Route::get('/GetShowById/{showId}', 'ApiController@getShowById');
Route::get('/GetShowByTVDBID/{TvdbId}', 'ApiController@getShowByTVDBID');
Route::get('/GetEpisodesForSeason/{showId}/{season}', 'ApiController@getEpisodesForSeason');
Route::get('/GetEpisodeById/{episodeId}', 'ApiController@getEpisodeById');
Route::get('/GetAllEpisodesForShow/{showId}', 'ApiController@getAllEpisodesForShow');

Route::get('/show/{showName}', 'ApiController@getShowById');
Route::get('/show/{showId}/episodes', 'ApiController@getAllEpisodesForShow');
Route::get('/show/{showId}/episodes/{season}', 'ApiController@getEpisodesForSeason');
Route::get('/episode/{episodeId}', 'ApiController@getEpisodeById');
