@php
$currentLang = app()->getLocale();
$x=1;
@endphp



<div class="table-responsive">
    <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Excel</button>
    <button type="button" class="btn btn-success" id="" onclick="printData()">Print</button>
    <table id="ack_added_value" class="table table-bordered mt-4 table-striped text-center " @if ($currentLang=='ar' ) style="direction: rtl; text-align: right" @endif>

        <thead class="tableItem" id="headers">
            <td>#</td>
            <td>@lang('site.description')</td>
            <td>@lang('site.date')</td>
            <td>@lang('site.debit')</td>
            <td>@lang('site.credit')</td>
            <td>@lang('site.balance')</td>
            <td>@lang('site.accoun_type')</td>
            <td>@lang('site.creator')</td>

        </thead>

        <tbody>
            <tr>
                <td></td>
                <td>الرصيد الافتتاحى</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$sum}}</td>
                <td></td>
                <td></td>

            </tr>
            @foreach($accountStatements as $statment)

            @php
            $total=$total+$statment->debit-$statment->credit;
            $total_debit=$total_debit+$statment->debit;
            $total_credit=$total_credit+$statment->credit;
            @endphp
            <tr>
                <td>{{$x++}}</td>
                <td style="width: 45%">{{$statment->description}}</td>
                <td>{{$statment->date}}</td>
                <td>{{$statment->debit}}</td>
                <td>{{$statment->credit}}</td>
                <td>{{$total}}</td>
                <td>{{$statment->accountType}}</td>
                <td>{{$statment->requester['name_' . $currentLang]}}</td>
            </tr>
            @endforeach

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$total_debit}}</td>
                <td>{{$total_credit}}</td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
        </tbody>
    </table>

</div>