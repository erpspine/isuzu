<div class="table-responsive">
    <table class="table" id="defectlist">
        <thead class="thead-light">
            <tr>
                <th>Defect Item</th>
                <th>Position</th>
                <th>Regulatory Related Parts </th>
                <th>Engineering information related parts(Including Caution Label) </th>
                <th>Action</th>
            </tr>
        </thead>
        @if (count($records) > 0)
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($records as $record)
                    <tr>
                        <td>
                            <input name="item_id[{{ $i }}]" type="hidden" value="{{ $record->id }}"  id="item_id_{{ $i }}" />
                            <textarea class="form-control" rows="3" placeholder="Defect Items" name="defect_name[]"
                                id="defect_name-{{ $i }}">{{ $record->defect_name }}</textarea>
                        </td>
                        <td class=""> <input type="text" class="form-control " placeholder="Position"
                                name="defect_position[]" value="{{ $record->defect_position }}"
                                id="defect_position-{{ $i }}" required></td>
                        <td> <select name="zone_a[{{ $i }}]" id="zone_a-{{ $i }}"
                                class="form-control custom-select" Required>
                                <option value="">Select</option>
                                <option value="0.5" {{ $record->zone_a == '0.5' ? 'selected' : '' }}>0.5</option>
                                <option value="1" {{ $record->zone_a == '1' ? 'selected' : '' }}>1</option>
                                <option value="5" {{ $record->zone_a == '5' ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $record->zone_a == '10' ? 'selected' : '' }}>10</option>
                                <option value="50" {{ $record->zone_a == '50' ? 'selected' : '' }}>50</option>
                            </select></td>
                        <td> <select name="zone_b[{{ $i }}]" id="zone_b-{{ $i }}"
                                class="form-control custom-select" Required>
                                <option value="">Select</option>
                                <option value="0.5" {{ $record->zone_b == '0.5' ? 'selected' : '' }}>0.5</option>
                                <option value="1" {{ $record->zone_b == '1' ? 'selected' : '' }}>1</option>
                                <option value="5" {{ $record->zone_a == '5' ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $record->zone_b == '10' ? 'selected' : '' }}>10</option>
                                <option value="50" {{ $record->zone_b == '50' ? 'selected' : '' }}>50</option>
                            </select></td>
                        <td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip"
                                data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        @endif
    </table>
</div>
