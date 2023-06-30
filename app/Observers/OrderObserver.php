<?php

namespace App\Observers;

use App\Order;
use App\Mwlitem;
use App\Http\Controllers\API\CreateXMLController;
use App\MppsioMwlItemBackup;
use App\MppsioPatientBackup;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        (new CreateXMLController($order))->store();
    }

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->where('uid', $order->uid)->update(['examed_at' => NOW()]);

        $mwlItem = Mwlitem::with(['patient'])->where('study_iuid', $order->uid)->first();

        if ($mwlItem == true) {
            MppsioMwlItemBackup::create([
                "pk" => $mwlItem->pk,
                "patient_fk" => $mwlItem->patient_fk,
                "sps_status" => $mwlItem->sps_status,
                "sps_id" => $mwlItem->sps_id,
                "start_datetime" => $mwlItem->start_datetime,
                "station_aet" => $mwlItem->station_aet,
                "station_name" => $mwlItem->station_name,
                "modality" => $mwlItem->modality,
                "perf_physician" => $mwlItem->perf_physician,
                "perf_phys_fn_sx" => $mwlItem->perf_phys_fn_sx,
                "perf_phys_gn_sx" => $mwlItem->perf_phys_gn_sx,
                "perf_phys_i_name" => $mwlItem->perf_phys_i_name,
                "perf_phys_p_name" => $mwlItem->perf_phys_p_name,
                "req_proc_id" => $mwlItem->req_proc_id,
                "accession_no" => $mwlItem->accession_no,
                "study_iuid" => $mwlItem->study_iuid,
                "updated_time" => $mwlItem->updated_time,
                "created_time" => $mwlItem->created_time,
                "item_attrs" => $mwlItem->item_attrs,
            ]);

            MppsioPatientBackup::create([
                "pk" => $mwlItem->patient->pk,
                "merge_fk" => $mwlItem->patient->merge_fk,
                "pat_id" => $mwlItem->patient->pat_id,
                "pat_id_issuer" => $mwlItem->patient->pat_id_issuer,
                "pat_name" => $mwlItem->patient->pat_name,
                "pat_fn_sx" => $mwlItem->patient->pat_fn_sx,
                "pat_gn_sx" => $mwlItem->patient->pat_gn_sx,
                "pat_i_name" => $mwlItem->patient->pat_i_name,
                "pat_p_name" => $mwlItem->patient->pat_p_name,
                "pat_birthdate" => $mwlItem->patient->pat_birthdate,
                "pat_sex" => $mwlItem->patient->pat_sex,
                "pat_custom1" => $mwlItem->patient->pat_custom1,
                "pat_custom2" => $mwlItem->patient->pat_custom2,
                "pat_custom3" => $mwlItem->patient->pat_custom3,
                "updated_time" => $mwlItem->patient->updated_time,
                "created_time" => $mwlItem->patient->created_time,
                "pat_attrs" => $mwlItem->patient->pat_attrs,
            ]);
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
