<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $banks = [
            [
                'bank_code' => '1',
                'bank_name' => 'QNB',
                'currency' => 'يورو',
                'bank_account_number' => '20310214867-29',
            ],
            [
                'bank_code' => '2',
                'bank_name' => 'QNB',
                'currency' => 'استرلينى',
                'bank_account_number' => '20310214868-26',
            ],
            [
                'bank_code' => '3',
                'bank_name' => 'QNB',
                'currency' => 'دولار',
                'bank_account_number' => '20310214869-23',
            ],
            [
                'bank_code' => '4',
                'bank_name' => 'QNB',
                'currency' => 'دولار',
                'bank_account_number' => '24635419003-21',
            ],
            [
                'bank_code' => '5',
                'bank_name' => 'QNB',
                'currency' => 'دولار',
                'bank_account_number' => '20315214068-81',
            ],
            
            [
                'bank_code' => '6',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '20315158062-95',
            ],
            [
                'bank_code' => '7',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '20310214866-32',
            ],
            [
                'bank_code' => '8',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '24635376722-85',
            ],
            [
                'bank_code' => '9',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '26937301120-77',
            ],
            [
                'bank_code' => '10',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '20319661912-15',
            ],
            [
                'bank_code' => '11',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '24639785014-92',
            ],
            [
                'bank_code' => '12',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '27590147687-54',
            ],
            [
                'bank_code' => '13',
                'bank_name' => 'QNB',
                'currency' => 'مصري',
                'bank_account_number' => '27590147692-54',
            ],
            [
                'bank_code' => '14',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'دولار',
                'bank_account_number' => '1383060583499800012',
            ],
            [
                'bank_code' => '15',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'يورو',
                'bank_account_number' => '1383060583499800023',
            ],
            [
                'bank_code' => '16',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382330583499800011',
            ],
            [
                'bank_code' => '17',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1383070583499800012',
            ],
            [
                'bank_code' => '18',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382090583499800014',
            ],
            [
                'bank_code' => '19',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382080583499800058',
            ], [
                'bank_code' => '20',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382080583499800069',
            ], [
                'bank_code' => '21',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382650583499800019',
            ], [
                'bank_code' => '22',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382630583499800019',
            ], [
                'bank_code' => '23',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382800583499800017',
            ], [
                'bank_code' => '24',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382800583499800028',
            ], [
                'bank_code' => '25',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382070583499800014',
            ], [
                'bank_code' => '26',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '783070507437700011',
            ], [
                'bank_code' => '27',
                'bank_name' => 'البنك الاهلى المصري',
                'currency' => 'مصري',
                'bank_account_number' => '1382080583499800078',
            ], [
                'bank_code' => '28',
                'bank_name' => 'بنك اسكندرية',
                'currency' => 'مصري',
                'bank_account_number' => '6006',
            ], [
                'bank_code' => '29',
                'bank_name' => 'بنك اسكندرية',
                'currency' => 'مصري',
                'bank_account_number' => '6014',
            ], [
                'bank_code' => '30',
                'bank_name' => 'بنك اسكندرية',
                'currency' => 'دولار',
                'bank_account_number' => '6001',
            ], [
                'bank_code' => '31',
                'bank_name' => 'بنك اسكندرية',
                'currency' => 'يورو',
                'bank_account_number' => '6003',
            ], [
                'bank_code' => '32',
                'bank_name' => 'بنك مصر',
                'currency' => 'مصري',
                'bank_account_number' => '1913010000000016',
            ], [
                'bank_code' => '33',
                'bank_name' => 'بنك مصر',
                'currency' => 'مصري',
                'bank_account_number' => '1913000000000028',
            ], [
                'bank_code' => '34',
                'bank_name' => 'بنك مصر',
                'currency' => 'دولار',
                'bank_account_number' => '1910001000005976',
            ], [
                'bank_code' => '35',
                'bank_name' => 'بنك مصر',
                'currency' => 'يورو',
                'bank_account_number' => '1910199000000608',
            ],
        ];


        foreach ($banks as $bank) {
            Bank::create([
                'bank_code' => $bank['bank_code'],
                'bank_name' => $bank['bank_name'],
                'currency' => $bank['currency'],
                'bank_account_number' => $bank['bank_account_number'],
            ]);
        }
    }
}
