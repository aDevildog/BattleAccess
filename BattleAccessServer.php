<?php
/**
 *
 * @Author      Johnathon "Devildog" Holmes
 * @Version     1.0 (initial)
 * @Package     BattleAccess
 * @Copyright   Copyright (c) 2013, Johnathon "Devildog" Holmes
 *
 */


class Server extends BattleAccessContainer {
    protected $accessUrl = "bf4/servers/show/pc/[[ID]]/?json=1";

    protected function parseData($data) {
        $data = json_decode($data, true);
        $data = $data['message'];
        $server = $data['SERVER_INFO'];
       // $server['players'] = $data['SERVER_PLAYERS'];
        $data = $server;

        if (!is_array($data) || !array_key_exists('guid', $data))
            throw new Exception ('Invalid server data');

        $returnData = array (
            'map'       => Server::mapName($data['map']),
            'gameId'    => $data['gameId'],
            //gameExpansions    SOON
            //mapMode           SOON
            'ip'            => $data['ip'],
            'matchId'       => $data['matchId'],
            'message'       => $data['extendedInfo']['message'],
            'bannerUrl'     => $data['extendedInfo']['bannerUrl'],
            'desc'          => $data['extendedInfo']['desc'],
            'game'          => Server::game($data['game']),
            'ranked'        => $data['ranked'],
            'platform'      => Server::platform($data['platform']),
            'maxQueue'      => $data['slots']['1']['max'],
            'queued'        => $data['slots']['1']['current'],
            'playersMax'    => $data['slots']['2']['max'],
            'players'       => $data['slots']['2']['current'],
            'commandersMax' => $data['slots']['4']['max'],
            'commanders'    => $data['slots']['4']['current'],
            'spectatorsMax' => $data['slots']['8']['max'],
            'spectators'    => $data['slots']['8']['current'],
            'guid'          => $data['guid'],
            'port'          => $data['port'],
            'gameExpansion' => $data['gameExpansion'],
            'name'          => $data['name'],
            /*
             * Settings
             * SOON
             * */
            'region'        => Server::region($data['region']),
            'hasPassword'   => $data['password'],
            'preset'        => Server::preset($data['preset']),
            'country'       => $data['country'],
        );

        return $returnData;
    }

    public static function mapName($id)
    {
        switch ($id)
        {
            case 'MP_Abandoned':
                return 'Zavod 311';
            case 'MP_Damage':
                return 'Lancang Dam';
            case 'MP_Flooded':
                return 'Flood Zone';
            case 'MP_Journey':
                return 'Golmud Railway';
            case 'MP_Naval':
                return 'Paracel Storm';
            case 'MP_Prison':
                return 'Operation Locker';
            case 'MP_Resort':
                return 'Hainan Resort';
            case 'MP_Siege':
                return 'Siege of Shanghai';
            case 'MP_TheDish':
                return 'Rogue Transmission';
            case 'MP_Tremors':
                return 'Dawnbreaker';
            case 'XP1_001':
                return 'Silk Road';
            case 'XP1_002':
                return 'Altai Range';
            case 'XP1_003':
                return 'Guilin Peaks';
            case 'XP1_004':
                return 'Dragon Pass';
            default:
                return 'Unknown';
        }
    }

    public static function region($id)
    {
        switch ($id)
        {
            case 1:
                return 'North America';
            case 2:
                return 'South America';
            case 4:
                return 'Antarctica';
            case 8:
                return 'Africa';
            case 16:
                return 'Europe';
            case 32:
                return 'Asia';
            case 64:
                return 'Oceania';
            default:
                return 'Unknown';
        }
    }

    public static function platform ($id)
    {
        switch ($id)
        {
            case 1:
                return 'PC';
            default:
                return 'Unknown';
        }
    }

    public static function preset($id)
    {
        switch ($id)
        {
            case 1:
                return 'Normal';
            case 2:
                return 'Hardcore';
            case 4:
                return 'Infantry Only';
            case 8:
                return 'Custom';
            default:
                return 'Unknown';
        }
    }

    public static function game($id)
    {
        switch ($id)
        {
            case 2048:
                return 'Battlefield 4';
            default:
                return "Unknown";
        }
    }
}