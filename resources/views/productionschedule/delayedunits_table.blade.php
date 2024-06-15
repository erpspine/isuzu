<table class="table table-striped table-bordered datatable-select-inputs no-wrap">
    <thead>
        <tr>
            <th>Date In</th>
            <th>Vin No.</th>
            <th>Shop</th>
            <th>Model Name.</th>
            <th>Lot No.</th>
            <th>Job No.</th>
            <th>No. of days</th>
        </tr>
    </thead>
    <tbody>
        @if (count($delays) > 0)
            @foreach ($delays as $item)
            <tr>
                <td>{{$item->datetime_in}}</td>
                <td>{{$item->vehicle->vin_no}}</td>
                <td>{{$item->shop->shop_name}}</td>
                <td>{{$item->models->model_name}}</td>
                <td>{{$item->vehicle->lot_no}}</td>
                <td>{{$item->vehicle->job_no}}</td>
                <td>{{\Carbon\carbon::parse($item->datetime_in)->diffInDays(\Carbon\carbon::parse($today))}}</td>
            </tr>
            @endforeach
        @endif

    </tbody>
    <tfoot>
        <tr>
            <th>Create date</th>
            <th>Code</th>
            <th>Job Description</th>
            <th></th>
        </tr>
    </tfoot>
</table>
