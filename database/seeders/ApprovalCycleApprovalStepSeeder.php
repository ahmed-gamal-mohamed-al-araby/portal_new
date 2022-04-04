<?php

namespace Database\Seeders;

use App\Models\ApprovalCycle;
use App\Models\ApprovalCycleApprovalStep;
use App\Models\ApprovalStep;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApprovalCycleApprovalStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectManagerStepID = ApprovalStep::where('code', 'PRO_M')->first()->id;
        $sectorHeadStepID = ApprovalStep::where('code', 'SEC_H')->first()->id;
        $purchasingSectorHeadStepID = ApprovalStep::where('code', 'PUR_H')->first()->id;
        $CEOSectorHeadStepID = ApprovalStep::where('code', 'CEO_H')->first()->id;
        $TechnicalOfficeCivilDepartmentManagerStepID = ApprovalStep::where('code', 'TEC_OFF_Civil')->first()->id;
        $TechnicalOfficeMEPDepartmentManagerStepID = ApprovalStep::where('code', 'TEC_OFF_MEP')->first()->id;
        $HEAD_ACC_AUDDepartmentManagerStepID = ApprovalStep::where('code', 'HEAD_ACC_AUD')->first()->id;
        $DIR_MDepartmentManagerStepID = ApprovalStep::where('code', 'DIR_M')->first()->id;



        $DepartmentManagerStepID = ApprovalStep::where('code', 'DEP_M')->first()->id;
        $Pln_HStepID = ApprovalStep::where('code', 'Pln_H')->first()->id;

        $PRConstructionITID = ApprovalCycle::where('code', 'IT-01')->first()->id;
        $PRConstructionCivilID = ApprovalCycle::where('code', 'C_Civil')->first()->id;
        $PRConstructionMEPID = ApprovalCycle::where('code', 'C_MEP')->first()->id;
        $ReqStationary = ApprovalCycle::where('code', 'stationary')->first()->id;

        $PRConstructionPO = ApprovalCycle::where('code', 'PO')->first()->id;
        $PRConstructionfactory = ApprovalCycle::where('code', 'factory')->first()->id;
        $PRConstructionCheaqueRequest = ApprovalCycle::where('code', 'cheque_request')->first()->id;

        $projectPurchasingStepID = ApprovalStep::where('code', 'PUR_DEP_M')->first()->id;
        $PRConstructionAuditManager = ApprovalStep::where('code', 'AUD_M')->first()->id;
        $PRConstructionCostManager = ApprovalStep::where('code', 'COST_M')->first()->id;

        $PRConstructionAccountAudit = ApprovalStep::where('code', 'HEAD_ACC_AUD')->first()->id;


        $factory_one = ApprovalStep::where('code', 'PLAN_MRP')->first()->id;
        $factory_two = ApprovalStep::where('code', 'PLAN_MRP_DIR')->first()->id;
        $factory_three = ApprovalStep::where('code', 'ADMI')->first()->id;
        $factory_four = ApprovalStep::where('code', 'RES_EXE')->first()->id;


        $creator = ApprovalStep::where('code', 'CREATOR')->first()->id;


        // statinary

        // Step1 (Project Manager)
        $ReqStationaryProjectManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $ReqStationary,
            'approval_step_id' => $DIR_MDepartmentManagerStepID,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);

        $PRConstructionHEAD_ACC_AUD = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $ReqStationary,
            'approval_step_id' => $HEAD_ACC_AUDDepartmentManagerStepID,
            'level' => '1',
            'previous_id' => $ReqStationaryProjectManager->id
            // 'next_id' => '',
        ]);

        $ReqStationaryProjectManager->update([
            'next_id' => $PRConstructionHEAD_ACC_AUD->id
        ]);



         // cheque_request PRConstructionChequeRequest

        //  $PRConstructionChequeDirectorStepID = ApprovalCycleApprovalStep::create([
        //     'approval_cycle_id' => $PRConstructionCheaqueRequest,
        //     'approval_step_id' => $creator,
        //     'level' => '1',
        //     'previous_id' => null
        //     // 'next_id' => '',
        // ]);

         $PRConstructionChequeDirectorPurchasingone = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $projectPurchasingStepID,
            'level' => '1',
            'previous_id' => null,
            // 'next_id' => '',
        ]);

        $PRConstructionChequecost = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $PRConstructionCostManager,
            'level' => '2',
            'previous_id' => $PRConstructionChequeDirectorPurchasingone->id
            // 'next_id' => '',
        ]);

        $PRConstructionChequeAuditManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $PRConstructionAuditManager,
            'level' => '3',
            'previous_id' => $PRConstructionChequecost->id
            // 'next_id' => '',
        ]);

        $PRConstructionChequeCostManagerthree = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $purchasingSectorHeadStepID,
            'level' => '4',
            'previous_id' => $PRConstructionChequeAuditManager->id
            // 'next_id' => '',
        ]);

         // Step4
         $PRConstructionChequePurchasingfour = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $PRConstructionAccountAudit,
            'level' => '5',
            'previous_id' => $PRConstructionChequeCostManagerthree->id
        ]);

         // Step5 (CEO)
         $PRConstructionChequeCEOfive = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCheaqueRequest,
            'approval_step_id' => $CEOSectorHeadStepID,
            'level' => '6',
            'previous_id' => $PRConstructionChequePurchasingfour->id
        ]);


         $PRConstructionChequeDirectorPurchasingone->update([
            'next_id' => $PRConstructionChequecost->id
        ]);

        $PRConstructionChequecost->update([
            'next_id' => $PRConstructionChequeAuditManager->id
        ]);

        $PRConstructionChequeAuditManager->update([
            'next_id' => $PRConstructionChequeCostManagerthree->id
        ]);

        $PRConstructionChequeCostManagerthree->update([
            'next_id' => $PRConstructionChequePurchasingfour->id
        ]);
        $PRConstructionChequePurchasingfour->update([
            'next_id' => $PRConstructionChequeCEOfive->id
        ]);


        // factory PRConstructionfactory
        $PRConstructionPOProjectPurchasingone = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionfactory,
            'approval_step_id' => $factory_one,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);

        $PRConstructionPOAuditManagertwo = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionfactory,
            'approval_step_id' => $factory_two,
            'level' => '2',
            'previous_id' => $PRConstructionPOProjectPurchasingone->id
            // 'next_id' => '',
        ]);

        $PRConstructionPOCostManagerthree = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionfactory,
            'approval_step_id' => $factory_three,
            'level' => '3',
            'previous_id' => $PRConstructionPOAuditManagertwo->id
            // 'next_id' => '',
        ]);

         // Step4
         $PRConstructionPOPurchasingfour = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionfactory,
            'approval_step_id' => $factory_four,
            'level' => '4',
            'previous_id' => $PRConstructionPOAuditManagertwo->id
        ]);

         // Step5 (CEO)
         $PRConstructionPOCEOfive = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionfactory,
            'approval_step_id' => $CEOSectorHeadStepID,
            'level' => '5',
            'previous_id' => $PRConstructionPOPurchasingfour->id
        ]);

         $PRConstructionPOProjectPurchasingone->update([
            'next_id' => $PRConstructionPOAuditManagertwo->id
        ]);
        $PRConstructionPOAuditManagertwo->update([
            'next_id' => $PRConstructionPOCostManagerthree->id
        ]);
        $PRConstructionPOCostManagerthree->update([
            'next_id' => $PRConstructionPOPurchasingfour->id
        ]);
        $PRConstructionPOPurchasingfour->update([
            'next_id' => $PRConstructionPOCEOfive->id
        ]);


        // $PRStationaryID = ApprovalCycle::where(['code', 'stationary'])->first()->id;
        // $PRITID = ApprovalCycle::where(['code', 'IT'])->first()->id;
        // $PRDesksID = ApprovalCycle::where(['code', 'desks'])->first()->id;
        // start PO
        $PRConstructionPOProjectPurchasing = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionPO,
            'approval_step_id' => $projectPurchasingStepID,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);

        $PRConstructionPOAuditManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionPO,
            'approval_step_id' => $PRConstructionCostManager,
            'level' => '2',
            'previous_id' => $PRConstructionPOProjectPurchasing->id
            // 'next_id' => '',
        ]);

        $PRConstructionPOCostManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionPO,
            'approval_step_id' => $PRConstructionAuditManager,
            'level' => '3',
            'previous_id' => $PRConstructionPOProjectPurchasing->id
            // 'next_id' => '',
        ]);

         // Step4
         $PRConstructionPOPurchasing = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionPO,
            'approval_step_id' => $purchasingSectorHeadStepID,
            'level' => '4',
            'previous_id' => $PRConstructionPOProjectPurchasing->id
        ]);

         // Step5 (CEO)
         $PRConstructionPOCEO = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionPO,
            'approval_step_id' => $CEOSectorHeadStepID,
            'level' => '5',
            'previous_id' => $PRConstructionPOPurchasing->id
        ]);

         $PRConstructionPOProjectPurchasing->update([
            'next_id' => $PRConstructionPOAuditManager->id
        ]);
        $PRConstructionPOAuditManager->update([
            'next_id' => $PRConstructionPOCostManager->id
        ]);
        $PRConstructionPOCostManager->update([
            'next_id' => $PRConstructionPOPurchasing->id
        ]);
        $PRConstructionPOPurchasing->update([
            'next_id' => $PRConstructionPOCEO->id
        ]);

        // Start PRConstructionCivil
        // Step1 (Project Manager)
        $PRConstructionCivilProjectManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCivilID,
            'approval_step_id' => $projectManagerStepID,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);
        // Step2 (Sector Head)
        $PRConstructionCivilSectorHead = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCivilID,
            'approval_step_id' => $sectorHeadStepID,
            'level' => '2',
            'previous_id' => $PRConstructionCivilProjectManager->id
        ]);

        // Step3 (Technical Office depend on group)
        $PRConstructionCivilTechinicalOffice = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCivilID,
            'approval_step_id' => $TechnicalOfficeCivilDepartmentManagerStepID,
            'level' => '3',
            'previous_id' => $PRConstructionCivilProjectManager->id
        ]);


        // Step4 (Purchasing Section Head)
        $PRConstructionCivilPurchasing = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCivilID,
            'approval_step_id' => $purchasingSectorHeadStepID,
            'level' => '4',
            'previous_id' => $PRConstructionCivilSectorHead->id
        ]);

        // Step5 (CEO)
        $PRConstructionCivilCEO = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionCivilID,
            'approval_step_id' => $CEOSectorHeadStepID,
            'level' => '5',
            'previous_id' => $PRConstructionCivilSectorHead->id
        ]);


        // Step1 (Project Manager) Next
        $PRConstructionCivilProjectManager->update([
            'next_id' => $PRConstructionCivilSectorHead->id
        ]);
        // Step2 (Sector Head) Next
        $PRConstructionCivilSectorHead->update([
            'next_id' => $PRConstructionCivilTechinicalOffice->id
        ]);
        // Step3 (Technical Office depend on group) Next
        $PRConstructionCivilTechinicalOffice->update([
            'next_id' => $PRConstructionCivilPurchasing->id
        ]);
        // Step4 (Purchasing Section Head) Next
        $PRConstructionCivilPurchasing->update([
            'next_id' => $PRConstructionCivilCEO->id
        ]);
        // End PRConstructionCivil
        //  -------------------------------------------------------------------------------------------------  //

        // // Start PRConstructionMEPID
        // Step1 (Project Manager)
        $PRConstructionMEPProjectManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionMEPID,
            'approval_step_id' => $projectManagerStepID,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);
        // Step2 (Sector Head)
        $PRConstructionMEPSectorHead = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionMEPID,
            'approval_step_id' => $sectorHeadStepID,
            'level' => '2',
            'previous_id' => $PRConstructionMEPProjectManager->id
        ]);

        // Step3 (Technical Office depend on group)
        $PRConstructionMEPTechinicalOffice = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionMEPID,
            'approval_step_id' => $TechnicalOfficeMEPDepartmentManagerStepID,
            'level' => '3',
            'previous_id' => $PRConstructionMEPProjectManager->id
        ]);


        // Step4 (Purchasing Section Head)
        $PRConstructionMEPPurchasing = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionMEPID,
            'approval_step_id' => $purchasingSectorHeadStepID,
            'level' => '4',
            'previous_id' => $PRConstructionMEPSectorHead->id
        ]);

        // Step5 (CEO)
        $PRConstructionMEPCEO = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionMEPID,
            'approval_step_id' => $CEOSectorHeadStepID,
            'level' => '5',
            'previous_id' => $PRConstructionMEPSectorHead->id
        ]);


        // Step1 (Project Manager) Next
        $PRConstructionMEPProjectManager->update([
            'next_id' => $PRConstructionMEPSectorHead->id
        ]);
        // Step2 (Sector Head) Next
        $PRConstructionMEPSectorHead->update([
            'next_id' => $PRConstructionMEPTechinicalOffice->id
        ]);
        // Step3 (Technical Office depend on group) Next
        $PRConstructionMEPTechinicalOffice->update([
            'next_id' => $PRConstructionMEPPurchasing->id
        ]);
        // Step4 (Purchasing Section Head) Next
        $PRConstructionMEPPurchasing->update([
            'next_id' => $PRConstructionMEPCEO->id
        ]);
        // End PRConstructionCivil
        // // End PRConstructionMEPID

         // // Start IT
        // Step1 (Department manager)
        $PRConstructionDepartmentManager = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionITID,
            'approval_step_id' => $DepartmentManagerStepID,
            'level' => '1',
            'previous_id' => null
            // 'next_id' => '',
        ]);
        // Step2 (PLN_H Head)
        $PRConstructionPLN_HSectorHead = ApprovalCycleApprovalStep::create([
            'approval_cycle_id' => $PRConstructionITID,
            'approval_step_id' => $Pln_HStepID,
            'level' => '2',
            'previous_id' => $PRConstructionDepartmentManager->id
        ]);


        // Step1 (Project Manager) Next
        $PRConstructionDepartmentManager->update([
            'next_id' => $PRConstructionPLN_HSectorHead->id
        ]);

        // End IT
        // // End IT
    }
}
