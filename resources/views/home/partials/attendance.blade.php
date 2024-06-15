
    @if ($master['unlogged'] > 0)
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-2">
                    <h3 class="text-success mb-0">[{{$master['unlogged']}}]</h3>
                    <span class="text-muted">Unlogged Attendance</span>
                </div>
                <div class="p-2 bg-warning ml-auto ">
                    <h3 class="text-white p-2 mb-0 "><i class="ti-signal "></i></h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($master['offscheduled'] == 0)
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-2">
                    <h3 class="text-success mb-0">[Missing]</h3>
                    <span class="text-muted">Offline Schedule</span>
                </div>
                <div class="p-2 bg-warning ml-auto ">
                    <h3 class="text-white p-2 mb-0 "><i class="ti-timer"></i></h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($master['fcwscheduled'] == 0)
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-2">
                    <h3 class="text-success mb-0">[Missing]</h3>
                    <span class="text-muted">FCW Schedule</span>
                </div>
                <div class="p-2 bg-warning ml-auto ">
                    <h3 class="text-white p-2 mb-0 "><i class="ti-timer"></i></h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-2">
                    <h3 class="text-success mb-0">[{{$master['delayed']}}]</h3>
                    <span class="text-muted">Delayed Units</span>
                </div>
                <div class="p-2 bg-warning ml-auto ">
                    <h3 class="text-white p-2 mb-0 "><i class="ti-server"></i></h3>
                </div>
            </div>
        </div>
    </div>
