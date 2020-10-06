<?php

/**
 * Class FakePodcastsAnalyticsSeeder
 * Inserts Fake Analytics in the database
 *
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Database\Seeds;
use App\Models\PodcastModel;
use App\Models\EpisodeModel;

use CodeIgniter\Database\Seeder;

class FakePodcastsAnalyticsSeeder extends Seeder
{
    public function run()
    {
        $podcast = (new PodcastModel())->first();

        $jsonUserAgents = json_decode(
            file_get_contents(
                'https://raw.githubusercontent.com/opawg/user-agents/master/src/user-agents.json'
            ),
            true
        );

        if ($podcast) {
            $firstEpisode = (new EpisodeModel())
                ->selectMin('published_at')
                ->first();

            for (
                $date = strtotime($firstEpisode->published_at);
                $date < strtotime('now');
                $date = strtotime(date('Y-m-d', $date) . ' +1 day')
            ) {
                $analytics_podcasts = [];
                $analytics_podcasts_by_country = [];
                $analytics_podcasts_by_episode = [];
                $analytics_podcasts_by_player = [];
                $analytics_podcasts_by_region = [];

                $episodes = (new EpisodeModel())
                    ->where([
                        'podcast_id' => $podcast->id,
                        'DATE(published_at) <=' => date('Y-m-d', $date),
                    ])
                    ->findAll();
                foreach ($episodes as $episode) {
                    $age = floor(
                        ($date - strtotime($episode->published_at)) / 86400
                    );
                    $proba1 = floor(exp(3 - $age / 40)) + 1;

                    for (
                        $num_line = 0;
                        $num_line < rand(1, $proba1);
                        $num_line++
                    ) {
                        $proba2 = floor(exp(6 - $age / 20)) + 10;

                        $player =
                            $jsonUserAgents[
                                rand(1, count($jsonUserAgents) - 1)
                            ];
                        $app = isset($player['app']) ? $player['app'] : '';
                        $device = isset($player['device'])
                            ? $player['device']
                            : '';
                        $os = isset($player['os']) ? $player['os'] : '';
                        $bot = isset($player['bot']) ? $player['bot'] : 0;

                        $fakeIp =
                            rand(0, 255) .
                            '.' .
                            rand(0, 255) .
                            '.' .
                            rand(0, 255) .
                            '.' .
                            rand(0, 255);

                        $cityReader = new \GeoIp2\Database\Reader(
                            WRITEPATH .
                                'uploads/GeoLite2-City/GeoLite2-City.mmdb'
                        );

                        $countryCode = 'N/A';
                        $regionCode = 'N/A';
                        $latitude = null;
                        $longitude = null;
                        try {
                            $city = $cityReader->city($fakeIp);

                            $countryCode = empty($city->country->isoCode)
                                ? 'N/A'
                                : $city->country->isoCode;

                            $regionCode = empty($city->subdivisions[0]->isoCode)
                                ? 'N/A'
                                : $city->subdivisions[0]->isoCode;
                            $latitude = round($city->location->latitude, 3);
                            $longitude = round($city->location->longitude, 3);
                        } catch (\GeoIp2\Exception\AddressNotFoundException $ex) {
                            //Bad luck, bad IP, nothing to do.
                        }

                        $hits = rand(0, $proba2);

                        $analytics_podcasts[] = [
                            'podcast_id' => $podcast->id,
                            'date' => date('Y-m-d', $date),
                            'hits' => $hits,
                        ];
                        $analytics_podcasts_by_country[] = [
                            'podcast_id' => $podcast->id,
                            'date' => date('Y-m-d', $date),
                            'country_code' => $countryCode,
                            'hits' => $hits,
                        ];
                        $analytics_podcasts_by_episode[] = [
                            'podcast_id' => $podcast->id,
                            'date' => date('Y-m-d', $date),
                            'episode_id' => $episode->id,
                            'age' => $age,
                            'hits' => $hits,
                        ];
                        $analytics_podcasts_by_player[] = [
                            'podcast_id' => $podcast->id,
                            'date' => date('Y-m-d', $date),
                            'app' => $app,
                            'device' => $device,
                            'os' => $os,
                            'bot' => $bot,
                            'hits' => $hits,
                        ];
                        $analytics_podcasts_by_region[] = [
                            'podcast_id' => $podcast->id,
                            'date' => date('Y-m-d', $date),
                            'country_code' => $countryCode,
                            'region_code' => $regionCode,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'hits' => $hits,
                        ];
                    }
                }
                $this->db
                    ->table('analytics_podcasts')
                    ->ignore(true)
                    ->insertBatch($analytics_podcasts);
                $this->db
                    ->table('analytics_podcasts_by_country')
                    ->ignore(true)
                    ->insertBatch($analytics_podcasts_by_country);
                $this->db
                    ->table('analytics_podcasts_by_episode')
                    ->ignore(true)
                    ->insertBatch($analytics_podcasts_by_episode);
                $this->db
                    ->table('analytics_podcasts_by_player')
                    ->ignore(true)
                    ->insertBatch($analytics_podcasts_by_player);
                $this->db
                    ->table('analytics_podcasts_by_region')
                    ->ignore(true)
                    ->insertBatch($analytics_podcasts_by_region);
            }
        } else {
            echo "Create one podcast and some episodes first.\n";
        }
    }
}