<div class="table-responsive">
    <table class="table" id="defectlist">
        <thead class="thead-light">
            <tr>
                <th>Size </th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Pos</th>
                <th>Factor</th>
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
                        <input name="item_id[{{ $i }}]" type="hidden" value="{{ $record->id }}"  id="item_id_{{ $i }}" />
                        <td><input type="text" class="form-control " placeholder="Size" name="defect_condition[]"
                                value="{{ $record->defect_condition }}" id="defect_condition-{{ $i }}"></td>
                        <td>
                            <textarea class="form-control" rows="3" placeholder="Description" name="defect_name[]"
                                id="defect_name-{{ $i }}">{{ $record->defect_name }}</textarea>
                        </td>
                        <td><input type="text" class="form-control " placeholder="Quantity" name="phenomenon[]"
                            value="{{ $record->phenomenon }}" id="phenomenon-{{ $i }}"></td>
                        <td class=""> <input type="text" class="form-control " placeholder="Position"
                                name="defect_position[]" value="{{ $record->defect_position }}"
                                id="defect_position-{{ $i }}" required></td>
                        <td> <select name="zone_a[{{ $i }}]" id="zone_a-{{ $i }}"
                                class="form-control custom-select">
                                <option value="">Select</option>
                                <option value="1" {{ $record->zone_a == '1' ? 'selected' : '' }}>1</option>
                                <option value="5" {{ $record->zone_a == '5' ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $record->zone_a == '10' ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $record->zone_a == '20' ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $record->zone_a == '50' ? 'selected' : '' }}>50</option>
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
