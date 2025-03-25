<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">

        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        @php
            $segment1 = Request::segment(1);
            $segment2 = Request::segment(2);
        @endphp
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('home') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Main Dashboard</span></a></li>

                @if (Auth()->User()->can('schedule-list') ||
                        Auth()->User()->can('schedule-create') ||
                        Auth()->User()->can('qualityrpt-position') ||
                        Auth()->User()->can('schedule-print') ||
                        Auth()->User()->can('swap-create') ||
                        Auth()->User()->can('swap-list') ||
                        Auth()->User()->can('prod-sche') ||
                        Auth()->User()->can('fcw-sche') ||
                        Auth()->User()->can('hist-sche') ||
                        Auth()->User()->can('Effny-dashboard') ||
                        Auth()->User()->can('performance-tack') ||
                        Auth()->User()->can('buffer-status') ||
                        Auth()->User()->can('actual-production') ||
                        Auth()->User()->can('qualityrpt-position'))
                    <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Responsiveness</span>
                    </li>

                    @if (Auth()->User()->can('schedule-list') ||
                            Auth()->User()->can('schedule-create') ||
                            Auth()->User()->can('qualityrpt-position'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-arrange-send-to-back"></i>
                                <span class="hide-menu">Scheduling</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('schedule-list')
                                    <li class="sidebar-item"><a href="{{ route('vehicleunits.index') }}"
                                            class="sidebar-link"><i class="mdi mdi-chart-line"></i>
                                            <span class="hide-menu"> Manage Schedule</span></a></li>
                                @endcan
                                @can('schedule-create')
                                    <li class="sidebar-item"><a href="{{ route('vehicleunits.create') }}"
                                            class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i>
                                            <span class="hide-menu">Import Schedule </span></a></li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    @can('schedule-print')
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('qrcode.index') }}" aria-expanded="false"><i class="mdi mdi-qrcode"></i><span
                                    class="hide-menu">Print Label</span></a></li>
                    @endcan



                    @if (Auth()->User()->can('prod-sche') || Auth()->User()->can('fcw-sche') || Auth()->User()->can('hist-sche'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-altimeter"></i><span
                                    class="hide-menu">Schedule Plan</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('prod-sche')
                                    <li class="sidebar-item"><a href="{{ route('productionschedule') }}"
                                            class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                                Offline Schedule</span></a>
                                    </li>
                                @endcan
                                @can('fcw-sche')
                                    <li class="sidebar-item"><a href="{{ route('fcwschedule') }}" class="sidebar-link"><i
                                                class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                                FCW Schedule </span></a>
                                    </li>
                                @endcan
                                @can('hist-sche')
                                    <li class="sidebar-item"><a href="{{ route('comments') }}" class="sidebar-link"><i
                                                class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                                Schedule History</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    @if (Auth()->User()->can('Effny-dashboard') ||
                            Auth()->User()->can('performance-tack') ||
                            Auth()->User()->can('buffer-status') ||
                            Auth()->User()->can('actual-production') ||
                            Auth()->User()->can('qualityrpt-position') ||
                            Auth()->User()->can('pos-track'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="fas fa-chart-bar"></i><span
                                    class="hide-menu">Reports</span></a>
                            <ul aria-expanded="false" class="collapse first-level">

                                @can('Effny-dashboard')
                                    <li class="sidebar-item"><a href="{{ route('plantefficiency') }}"
                                            class="sidebar-link"><i class="mdi mdi-arrange-send-to-back"></i> <span
                                                class="hide-menu">
                                                Efficiency</span></a>
                                    </li>
                                @endcan
                                @can('performance-tack')
                                    <li class="sidebar-item"><a href="{{ route('trackperformance') }}"
                                            class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                                class="hide-menu">
                                                Performance Tracking</span></a>
                                    </li>
                                @endcan
                                @can('buffer-status')
                                    <!--<li class="sidebar-item"><a href="{{ route('bufferstatus') }}" class="sidebar-link"><i
                                            class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                                Buffer Status</span></a>-->
                            </li>
                        @endcan
                        @can('actual-production')
                            <li class="sidebar-item"><a href="{{ route('actualproduction') }}" class="sidebar-link"><i
                                        class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                        Actual Production</span></a>
                            </li>
                        @endcan
                        @can('qualityrpt-position')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('currentunitstage') }}" aria-expanded="false"><i
                                        class="mdi mdi-parking"></i><span class="hide-menu">Current Position</span></a></li>
                        @endcan
                        @can('delayed-units')
                            <li class="sidebar-item"><a href="{{ route('delayedunits') }}" class="sidebar-link"><i
                                        class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                        Delayed Units</span></a>
                            </li>
                        @endcan
                        @can('pos-track')
                            <li class="sidebar-item"><a href="{{ route('dashboard') }}" class="sidebar-link"><i
                                        class="mdi mdi-av-timer"></i> <span class="hide-menu">
                                        WIP Tracking</span></a>
                            </li>
                        @endcan
                        @can('pos-track')
                            <li class="sidebar-item"><a href="{{ route('treceable') }}" class="sidebar-link"><i
                                        class="mdi mdi-av-timer"></i> <span class="hide-menu">
                                        Treacability Report</span></a>
                            </li>
                        @endcan
            </ul>
            </li>
            @endif

            @endif


            @if (Auth()->User()->can('routing-list') ||
                    Auth()->User()->can('routing-create') ||
                    Auth()->User()->can('routing-bymodel') ||
                    Auth()->User()->can('swap-create') ||
                    Auth()->User()->can('swap-list') ||
                    Auth()->User()->can('drr-list') ||
                    Auth()->User()->can('defect-list') ||
                    Auth()->User()->can('gca-score') ||
                    Auth()->User()->can('reroute-list') ||
                    Auth()->User()->can('reroute-create') ||
                    Auth()->User()->can('drltgt-list') ||
                    Auth()->User()->can('drltgt-create') ||
                    Auth()->User()->can('drrtgt-list') ||
                    Auth()->User()->can('drrtgt-create') ||
                    Auth()->User()->can('mangca-target') ||
                    Auth()->User()->can('sort-routing'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Quality</span>
                </li>
                @if (Auth()->User()->can('routing-list') ||
                        Auth()->User()->can('routing-create') ||
                        Auth()->User()->can('routing-bymodel') ||
                        Auth()->User()->can('sort-routing'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-svg"></i><span
                                class="hide-menu">Routing Query</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('routing-list')
                                <li class="sidebar-item"><a href="{{ route('querycategory.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                            Manage Routing Query</span></a>
                                </li>
                            @endcan
                            @can('routing-create')
                                <li class="sidebar-item"><a href="{{ route('querycategory.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Add Routing Query </span></a>
                                </li>
                            @endcan
                            @can('routing-bymodel')
                                <li class="sidebar-item"><a href="{{ route('querybymodel') }}" class="sidebar-link"><i
                                            class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                            Query By Model </span></a>
                                </li>
                            @endcan
                            @can('sort-routing')
                                <li class="sidebar-item"><a href="{{ route('sortroutingquery') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Sort Routings </span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if (Auth()->User()->can('drr-list') ||
                        Auth()->User()->can('defect-list') ||
                        Auth()->User()->can('gca-score') ||
                        Auth()->User()->can('swap-create') ||
                        Auth()->User()->can('swap-list') ||
                        Auth()->User()->can('reroute-list') ||
                        Auth()->User()->can('reroute-create'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-apple-keyboard-command"></i><span class="hide-menu">Unit
                                Management</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('defect-list')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('defectsummary') }}" aria-expanded="false"><i
                                            class="mdi mdi-close-box"></i><span class="hide-menu">Defects List</span></a>
                                </li>
                            @endcan
                            @can('drr-list')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('drrlist') }}" aria-expanded="false"><i
                                            class="mdi mdi-fire"></i><span class="hide-menu">DRR List</span></a></li>
                            @endcan
                            @can('gca-score')
                                <li class="sidebar-item"><a href="{{ route('gcascore.index') }}" class="sidebar-link"><i
                                            class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                            GCA Score </span></a></li>
                            @endcan
                            @can('swap-list')
                                <li class="sidebar-item"><a href="{{ route('swapunit.index') }}" class="sidebar-link"><i
                                            class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                            Manage Swap</span></a></li>
                            @endcan
                            @can('swap-create')
                                <li class="sidebar-item"><a href="{{ route('swapunit.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Add Swap </span></a></li>
                            @endcan
                            @can('reroute-create')
                                <li class="sidebar-item"><a href="{{ route('rerouting.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                            Create Re-Routing </span></a></li>
                            @endcan


                            @can('reroute-list')
                                <li class="sidebar-item"><a href="#" class="sidebar-link"><i
                                            class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                            List Re-Routing</span></a></li>
                            @endcan
                            @can('change-defect-inputs')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('changetraceble.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-fire"></i><span class="hide-menu">Change Input</span></a>
                                </li>
                            @endcan

                            @can('gcaboard-create')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('fcaboard.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-fire"></i><span class="hide-menu">Create GCA Board
                                            Report</span></a></li>
                            @endcan
                            @can('gcaboard-followup')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('gcafollowup.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-fire"></i><span class="hide-menu">GCA Follow Up</span></a>
                                </li>
                            @endcan




                        </ul>
                    </li>
                @endif

                @if (Auth()->User()->can('qualityrpt-marked') ||
                        Auth()->User()->can('defect-list') ||
                        Auth()->User()->can('drr-list') ||
                        Auth()->User()->can('drl-report') ||
                        Auth()->User()->can('drl-report'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span
                                class="hide-menu">Quality Report</span></a>
                        <ul aria-expanded="false" class="collapse first-level">

                            @can('qualityrpt-marked')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('markedunit') }}" aria-expanded="false"><i
                                            class="mdi mdi-marker-check"></i><span class="hide-menu">Marked
                                            Routings</span></a></li>
                            @endcan

                            @can('drl-report')
                                <li class="sidebar-item"><a
                                        href="{{ route('drl', ['' . encrypt_data('plant') . '', '' . encrypt_data('today') . '', '' . encrypt_data('' . this_day() . '') . '']) }}"
                                        class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                            class="hide-menu">
                                            Direct Run Loss</span></a></li>
                            @endcan
                            @can('drr-report')
                                <li class="sidebar-item"><a
                                        href="{{ route('drr', ['' . encrypt_data('plant') . '', '' . encrypt_data('today') . '', '' . encrypt_data(this_day()) . '']) }}"
                                        class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                            class="hide-menu">
                                            Direct Run Rate</span></a></li>
                            @endcan

                            <li class="sidebar-item"><a href="{{ route('searchunitprofile') }}"
                                    class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                        class="hide-menu">
                                        Vehicle Profile</span></a></li>

                        </ul>
                    </li>
                @endif




                @if (Auth()->User()->can('drltgt-list') ||
                        Auth()->User()->can('drltgt-create') ||
                        Auth()->User()->can('drrtgt-list') ||
                        Auth()->User()->can('drrtgt-create') ||
                        Auth()->User()->can('mangca-target') ||
                        Auth()->User()->can('gcatgt-create'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-target"></i><span
                                class="hide-menu">QualityTargets</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('drltgt-list')
                                <li class="sidebar-item"><a href="{{ route('drltarget.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                            Manage DRL Target</span></a></li>
                            @endcan
                            @can('drltgt-create')
                                <li class="sidebar-item"><a href="{{ route('drltarget.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Create DRL Target </span></a></li>
                            @endcan
                            @can('drrtgt-list')
                                <li class="sidebar-item"><a href="{{ route('drrtarget.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                            Manage DRR Target</span></a></li>
                            @endcan
                            @can('drrtgt-create')
                                <li class="sidebar-item"><a href="{{ route('drrtarget.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Create DRR Target </span></a></li>
                            @endcan


                        </ul>
                    </li>
                @endif

            @endif

            <!--GCA--->
            @if (Auth()->User()->can('gca-settings-auditreporting') ||
                    Auth()->User()->can('gca-settings-weighingstandards') ||
                    Auth()->User()->can('gca-settings-steps') ||
                    Auth()->User()->can('gca-settings-target') ||
                    Auth()->User()->can('gca-cv-settings-instructions') ||
                    Auth()->User()->can('gca-cv-settings-inspectionitems') ||
                    Auth()->User()->can('gca-cv-settings-inspectioncategory') ||
                    Auth()->User()->can('gca-cv-settings-checksheetitem') ||
                    Auth()->User()->can('gca-lcv-settings-instructions') ||
                    Auth()->User()->can('gca-lcv-settings-inspectionitems') ||
                    Auth()->User()->can('gca-lcv-settings-inspectioncategory') ||
                    Auth()->User()->can('gca-lcv-settings-checksheetitem') ||
                    Auth()->User()->can('gca-report-defects') ||
                    Auth()->User()->can('gca-report-dpvwdpv'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i><span class="hide-menu">GCA</span>
                </li>
                <li
                    class="sidebar-item {{ $segment1 == 'gca-audit-report-category' || $segment1 == 'decrepancy_weight' || $segment1 == 'gcasteps' ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class="mdi mdi-broom"></i><span class="hide-menu">Gca
                            Settings</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ $segment1 == 'gca-audit-report-category' || $segment1 == 'decrepancy_weight' || $segment1 == 'gcasteps' ? 'in' : '' }}">
                        @can('gca-settings-auditreporting')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('gca-audit-report-category.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Audit Reporting</span></a></li>
                        @endcan
                        @can('gca-settings-weighingstandards')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('decrepancy_weight.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Weighting Standards</span></a>
                            </li>
                        @endcan
                        @can('gca-settings-steps')
                            <li class="sidebar-item"><a href="{{ route('gcasteps.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-chart-line {{ $segment1 == 'gcasteps' ? 'active' : '' }}"></i>
                                    <span class="hide-menu">
                                        Steps</span></a>
                            </li>
                        @endcan
                        @can('gca-settings-target')
                            <li class="sidebar-item"><a href="{{ route('gcatarget') }}" class="sidebar-link"><i
                                        class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                        Create GCA Target </span></a></li>
                        @endcan



                    </ul>
                </li>

                <li
                    class="sidebar-item {{ $segment1 == 'gcacvchecksheet' || $segment1 == 'gcacvchecksheetitem' || $segment1 == 'add-instructions-cv' || $segment1 == 'appearance-zones-cv-add' || $segment1 == 'edit-instructions-cv' ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class="mdi mdi-svg"></i><span class="hide-menu">CV
                            Settings</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ $segment1 == 'appearance-zones-cv' || $segment1 == 'gcacvchecksheet' || $segment1 == 'gcacvchecksheetitem' || $segment1 == 'add-instructions-cv' || $segment1 == 'appearance-zones-cv-add' || $segment1 == 'edit-instructions-cv' ? 'in' : '' }}">

                        @can('gca-cv-settings-instructions')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('appearance-zones-cv') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Instructions </span></a></li>
                        @endcan

                        @can('gca-cv-settings-inspectionitems')
                            <li class="sidebar-item"><a href="{{ route('gcacvchecksheet.index') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        View Inspection Items </span></a>
                            </li>
                        @endcan

                        @can('gca-cv-settings-inspectioncategory')
                            <li class="sidebar-item"><a href="{{ route('gcacvchecksheet.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        Add Inspection Category </span></a>
                            </li>
                        @endcan


                        @can('gca-cv-settings-checksheetitem')
                            <li class="sidebar-item"><a href="{{ route('gcacvchecksheetitem.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        Add Checksheet Item </span></a>
                            </li>
                        @endcan




                    </ul>
                </li>


                <li
                    class="sidebar-item {{ $segment1 == 'lcvinstructions' || $segment1 == 'gcalcvchecksheet' || $segment1 == 'gcalcvchecksheetitem' || $segment1 == 'add-instructions-lcv' || $segment1 == 'appearance-zones-lcv-add' ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false"><i class="mdi mdi-svg"></i><span class="hide-menu">LCV
                            Settings</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ $segment1 == 'lcvinstructions' || $segment1 == 'gcalcvchecksheet' || $segment1 == 'gcalcvchecksheetitem' || $segment1 == 'add-instructions-lcv' || $segment1 == 'appearance-zones-lcv-add' ? 'in' : '' }}">

                        @can('gca-lcv-settings-instructions')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('lcvinstructions.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Instructions </span></a></li>
                        @endcan

                        @can('gca-lcv-settings-inspectionitems')
                            <li class="sidebar-item"><a href="{{ route('gcalcvchecksheet.index') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        View Inspection Items </span></a>
                            </li>
                        @endcan

                        @can('gca-lcv-settings-inspectioncategory')
                            <li class="sidebar-item"><a href="{{ route('gcalcvchecksheet.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        Add Inspection Category </span></a>
                            </li>
                        @endcan


                        @can('gca-lcv-settings-checksheetitem')
                            <li class="sidebar-item"><a href="{{ route('gcalcvchecksheetitem.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                        class="hide-menu">
                                        Add Checksheet Item </span></a>
                            </li>
                        @endcan




                    </ul>
                </li>



                <li
                    class="sidebar-item {{ $segment1 == 'gcadefects-action' || $segment1 == 'gcadpvwdpv' ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow waves-effect waves-dark {{ $segment1 == 'gcapreweek' || $segment1 == 'gcasamplesize' ? 'active' : '' }}"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-gantt"></i><span
                            class="hide-menu">Gca Report</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ $segment1 == 'gcadefects-action' || $segment1 == 'gcadpvwdpv' ? 'in' : '' }}">
                        @can('gca-report-defects')
                            <li class="sidebar-item"><a href="{{ route('gcadefects-action.index') }}"
                                    class="sidebar-link"><i class="mdi mdi-chart-line"></i> <span class="hide-menu">
                                        Defects</span></a>
                            </li>
                        @endcan
                        @can('gca-report-dpvwdpv')
                            <li class="sidebar-item "><a href="{{ route('gcadpvwdpv') }}" class="sidebar-link "><i
                                        class="mdi mdi-chart-scatterplot-hexbin"></i> <span class="hide-menu">
                                        DPV & WDPV </span></a>
                            </li>
                        @endcan






                    </ul>
                </li>
            @endif

            @if (Auth()->User()->can('tool-list') ||
                    Auth()->User()->can('tool-create') ||
                    Auth()->User()->can('tool-edit') ||
                    Auth()->User()->can('tool-delete') ||
                    Auth()->User()->can('joint-list') ||
                    Auth()->User()->can('joint-create') ||
                    Auth()->User()->can('joint-edit') ||
                    Auth()->User()->can('joint-delete') ||
                    Auth()->User()->can('calibration-list') ||
                    Auth()->User()->can('calibration-create') ||
                    Auth()->User()->can('calibration-edit') ||
                    Auth()->User()->can('calibration-delete') ||
                    Auth()->User()->can('notification-email-list') ||
                    Auth()->User()->can('notification-email-create') ||
                    Auth()->User()->can('notification-email-edit') ||
                    Auth()->User()->can('notification-email-delete') ||
                    Auth()->User()->can('trendchart-value-list') ||
                    Auth()->User()->can('trendchart-value-edit') ||
                    Auth()->User()->can('trendchart-value-delete') ||
                    Auth()->User()->can('trendchart-report') ||
                    Auth()->User()->can('ttms-print-cert') ||
                    Auth()->User()->can('ttms-schedule-calendar') ||
                    Auth()->User()->can('ttms-schedule-list') ||
                    Auth()->User()->can('ttms-action-plan'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i><span class="hide-menu">Torque
                        Management System</span></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-wrench"></i><span
                            class="hide-menu">Torque Calibration Management System</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('tool-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('tcm.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Tool Inventory</span></a></li>
                        @endcan
                        @can('tool-create')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('tcm.create') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Create Tool</span></a></li>
                        @endcan
                        @can('joint-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('tcmjoint.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Joint Inventory</span></a></li>
                        @endcan
                        @can('joint-create')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('tcmjoint.create') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Create Joint</span></a></li>
                        @endcan
                        @can('joint-create')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('importtool') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Import Tool</span></a></li>
                        @endcan

                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-shuffle-variant"></i><span
                            class="hide-menu">Calibration</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('calibration-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('qcoscalibration.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Manage</span></a></li>
                        @endcan
                        @can('calibration-create')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('qcoscalibration.create') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Create </span></a></li>
                        @endcan
                        @can('ttms-print-cert')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('calibrarioncert.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Print Cert </span></a></li>
                        @endcan
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-bell"></i><span
                            class="hide-menu">Emails </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('notification-email-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('qcosemail.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Manage Emails</span></a></li>
                        @endcan
                        @can('notification-email-create')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('qcosemail.create') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Create Emails </span></a></li>
                        @endcan
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-line"></i><span
                            class="hide-menu">TTMS </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('trendchart-report')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('qcossheet.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Trend Chart</span></a></li>
                        @endcan
                        @can('trendchart-value-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('monitoringsheet.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Trend Chart Values </span></a>
                            </li>
                        @endcan
                        @can('ttms-action-plan')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('ttmsactionplan.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">TTMS Action Plan
                                    </span></a></li>
                        @endcan
                        @can('ttms-schedule-calendar')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('schedulereport') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Schedule Calendar
                                    </span></a></li>
                        @endcan
                        @can('ttms-schedule-list')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('scheduler.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-fire"></i><span class="hide-menu">Schedule List
                                    </span></a></li>
                        @endcan

                    </ul>
                </li>
            @endif



            @if (Auth()->User()->can('attendance-mark') ||
                    Auth()->User()->can('attendance-preview') ||
                    Auth()->User()->can('overtime-report') ||
                    Auth()->User()->can('set-default') ||
                    Auth()->User()->can('manage-target') ||
                    Auth()->User()->can('view-target') ||
                    Auth()->User()->can('set-stdhrs') ||
                    Auth()->User()->can('hc-summary') ||
                    Auth()->User()->can('hc-list') ||
                    Auth()->User()->can('hc-import') ||
                    Auth()->User()->can('set-default') ||
                    Auth()->User()->can('manage-target') ||
                    Auth()->User()->can('view-target') ||
                    Auth()->User()->can('set-stdhrs') ||
                    Auth()->User()->can('bulk-auth'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">People</span>
                </li>
                @can('attendance-mark')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('attendance_view') }}" aria-expanded="false"><i
                                class="mdi mdi-pencil-box-outline"></i><span class="hide-menu">Attendance & OT</span></a>
                    </li>
                @endcan
                @can('overtime-preview')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('bulkauth') }}" aria-expanded="false"><i class="mdi mdi-av-timer"></i><span
                                class="hide-menu">Authorization OT</span></a></li>
                @endcan
                @can('bulk-auth')
                    <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="/attendancepreview" aria-expanded="false"><i class="mdi mdi-ticket-confirmation"></i><span
                                class="hide-menu">Bulk Authorization</span></a></li>-->
                @endcan
                @if (Auth()->User()->can('hc-summary') || Auth()->User()->can('hc-list') || Auth()->User()->can('hc-import'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-account-settings"></i><span class="hide-menu">Head Count</span></a>
                        <ul aria-expanded="false" class="collapse first-level">

                            @can('hc-summary')
                                <li class="sidebar-item"><a href="/staffsummary" class="sidebar-link"><i
                                            class="mdi mdi-arrange-bring-to-front"></i> <span class="hide-menu">
                                            Staffs Summary</span></a></li>
                            @endcan
                            @can('hc-create')
                                <li class="sidebar-item"><a href="/employee/create" class="sidebar-link"><i
                                            class="mdi mdi-arrange-bring-to-front"></i> <span class="hide-menu">
                                            Add Staffs</span></a></li>
                            @endcan
                            @can('hc-list')
                                <li class="sidebar-item"><a href="/employee" class="sidebar-link"><i
                                            class="mdi mdi-arrange-bring-to-front"></i> <span class="hide-menu">
                                            Manage Staffs</span></a></li>
                            @endcan
                            @can('hc-import')
                                <li class="sidebar-item"><a href="{{ route('importemployee') }}" class="sidebar-link"><i
                                            class="mdi mdi-arrange-bring-to-front"></i> <span class="hide-menu">
                                            Import Staff List</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth()->User()->can('people-report') ||
                        Auth()->User()->can('people-summary') ||
                        Auth()->User()->can('attend-register') ||
                        Auth()->User()->can('overtime-report'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-poll"></i><span
                                class="hide-menu">People Report</span></a>
                        <ul aria-expanded="false" class="collapse first-level">

                            @can('people-report')
                                <li class="sidebar-item"><a href="{{ route('peopleAttreport') }}"
                                        class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                            class="hide-menu">
                                            View Reports</span></a>
                                </li>
                            @endcan

                            @can('overtime-report')
                                <li class="sidebar-item"><a href="{{ route('overtimebyshop') }}" class="sidebar-link"><i
                                            class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                            Overtime Report</span></a>
                                </li>
                            @endcan
                            @can('plant-register')
                                <li class="sidebar-item"><a href="{{ route('plantattendancereg') }}"
                                        class="sidebar-link"><i class="mdi mdi-backup-restore"></i> <span
                                            class="hide-menu">
                                            Plant Register</span></a>
                                </li>
                            @endcan
                            @can('shop-attendance')
                                <li class="sidebar-item"><a href="{{ route('attendceregister') }}"class="sidebar-link"><i
                                            class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                            Shop Attendance</span></a>
                                </li>
                            @endcan

                            @can('plant-attendance')
                                <li class="sidebar-item"><a href="{{ route('plantattendance') }}"class="sidebar-link"><i
                                            class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                            Plant Attendance</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth()->User()->can('set-default') ||
                        Auth()->User()->can('manage-target') ||
                        Auth()->User()->can('view-target') ||
                        Auth()->User()->can('set-stdhrs'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false">
                            <i class="far fa-sun"></i><span class="hide-menu">People Settings</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('set-default')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('sethours') }}" aria-expanded="false"><span class="hide-menu">
                                            Set Defoult Hours</span></a></li>
                            @endcan
                            @can('manage-target')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('createtargets') }}" aria-expanded="false"><span
                                            class="hide-menu">
                                            Create Targets</span></a>
                                </li>
                            @endcan
                            @can('view-target')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('settargets') }}" aria-expanded="false"><span class="hide-menu">
                                            Manage Targets</span></a>
                                </li>
                            @endcan
                            @can('set-stdhrs')
                                <li class="sidebar-item"><a href="/stdworkinghrs" class="sidebar-link"><i
                                            class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                            STD Working Hrs</span></a></li>
                            @endcan

                        </ul>
                    </li>
                @endif
            @endif


            @if (Auth()->User()->can('response-summary') ||
                    Auth()->User()->can('people-summary') ||
                    Auth()->User()->can('quality-summary'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Summary Graphs</span>
                </li>
                @can('people-summary')
                    <li class="sidebar-item"><a href="{{ route('yrpeoplesummary') }}" class="sidebar-link"><i
                                class="mdi mdi-chart-histogram"></i> <span class="hide-menu">
                                People Graphs</span></a>
                    </li>
                @endcan
                @can('quality-summary')
                    <!--<li class="sidebar-item"><a href="{{ route('yrqualitysummary') }}" class="sidebar-link"><i
                                class="mdi mdi-chart-histogram"></i> <span class="hide-menu">
                                    Quality Graphs</span></a>-->
                    </li>
                @endcan
                @can('response-summary')
                    <li class="sidebar-item"><a href="{{ route('yrresponsesummary') }}" class="sidebar-link"><i
                                class="mdi mdi-chart-areaspline"></i> <span class="hide-menu">
                                Responsiveness Graphs</span></a>
                    </li>
                @endcan
            @endif


            <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                <span class="hide-menu">Display</span>
            </li>
            <li class="sidebar-item"><a href="{{ route('screenboard') }}" target="_blank" class="sidebar-link">
                    <i class="mdi mdi-dice-4"></i>
                    <span class="hide-menu">Screenboard</span></a>
            </li>
            <li class="sidebar-item"><a href="{{ route('fcadashboard') }}" target="_blank" class="sidebar-link">
                    <i class="mdi mdi-dice-4"></i>
                    <span class="hide-menu">GCA Board</span></a>
            </li>


            @can('attendance-preview')
                <!--<li class="sidebar-item"><a href="{{ route('otpreview') }}" class="sidebar-link"><i
                                class="mdi mdi-av-timer"></i> <span class="hide-menu">
                                    Authorization OT</span></a>
                            </li>-->
            @endcan

            @can('overtime-mark')
                <!--<li class="sidebar-item"><a href="{{ route('overtime.index') }}" class="sidebar-link"><i
                                class="mdi mdi-arrange-send-to-back"></i> <span class="hide-menu">
                                    Record Overtime</span></a>
                            </li>-->
            @endcan

            @can('auth-hrs')
                <!--<li class="sidebar-item"><a href="{{ route('authorisedhrs') }}" class="sidebar-link"><i
                                class="mdi mdi-backup-restore"></i> <span class="hide-menu">
                                    Authorised Hrs</span></a>
                            </li>-->
            @endcan
            @if (Auth()->User()->can('material-management-list-list') ||
                    Auth()->User()->can('material-management-list-create') ||
                    Auth()->User()->can('material-management-model-list') ||
                    Auth()->User()->can('material-management-model-create'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Material Management</span>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-material-ui"></i><span
                            class="hide-menu">Material Management</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('material-management-list-list')
                            <li class="sidebar-item"><a href="{{ route('material-distribution.index') }}"
                                    class="sidebar-link"><i class="mdi mdi-arrange-bring-to-front"></i> <span
                                        class="hide-menu">
                                        Manage List </span></a></li>
                        @endcan

                        @can('material-management-list-create')
                            <li class="sidebar-item"><a href="{{ route('material-distribution.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-arrange-bring-to-front"></i> <span
                                        class="hide-menu">
                                        Import List</span></a></li>
                        @endcan
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-group"></i><span
                            class="hide-menu">Distribution Models</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('material-management-model-list')
                            <li class="sidebar-item"><a href="{{ route('material-distribution-model.index') }}"
                                    class="sidebar-link"><i class="mdi mdi-arrange-bring-to-front"></i> <span
                                        class="hide-menu">
                                        Manage Models </span></a></li>
                        @endcan

                        @can('material-management-model-create')
                            <li class="sidebar-item"><a href="{{ route('material-distribution-model.create') }}"
                                    class="sidebar-link"><i class="mdi mdi-arrange-bring-to-front"></i> <span
                                        class="hide-menu">
                                        Add Models</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endif


            @if (Auth()->User()->can('model-list') ||
                    Auth()->User()->can('model-create') ||
                    Auth()->User()->can('shops-list') ||
                    Auth()->User()->can('route-list') ||
                    Auth()->User()->can('route-mapping') ||
                    Auth()->User()->can('unit-category') ||
                    Auth()->User()->can('work-schedule'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Settings</span>
                </li>

                @if (Auth()->User()->can('model-list') ||
                        Auth()->User()->can('model-create') ||
                        Auth()->User()->can('shops-list') ||
                        Auth()->User()->can('route-list') ||
                        Auth()->User()->can('route-mapping') ||
                        Auth()->User()->can('unit-category') ||
                        Auth()->User()->can('work-schedule'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-svg"></i><span
                                class="hide-menu"> General Settings</span></a>
                        <ul aria-expanded="false" class="collapse first-level">

                            @can('model-list')
                                <li class="sidebar-item"><a href="{{ route('vehiclemodels.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-ungroup"></i> <span class="hide-menu">
                                            Manage Models</span></a></li>
                            @endcan
                            @can('model-create')
                                <li class="sidebar-item"><a href="{{ route('vehiclemodels.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-chart-scatterplot-hexbin"></i> <span
                                            class="hide-menu">
                                            Add Model </span></a></li>
                            @endcan
                            @can('shops-list')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="/shops" aria-expanded="false"><i
                                            class="mdi mdi-image-filter-tilt-shift"></i>
                                        <span class="hide-menu">Shops</span></a></li>
                            @endcan
                            @can('sections-list')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('sections') }}" aria-expanded="false"><i
                                            class="mdi mdi-airplay"></i>
                                        <span class="hide-menu">Sections</span></a></li>
                            @endcan
                            @can('route-list')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('unitroute.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-airplane"></i>
                                        <span class="hide-menu">Routes</span></a></li>
                            @endcan
                            @can('route-mapping')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('unitmapping.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-airplane-takeoff"></i>
                                        <span class="hide-menu">Route Mapping</span></a></li>
                            @endcan
                            @can('unit-category')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('vehicletype.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-car-wash"></i><span class="hide-menu">Unit Category</span></a>
                                </li>
                            @endcan
                            @can('work-schedule')
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('workschedule.index') }}" aria-expanded="false"><i
                                            class="mdi mdi-calendar-check"></i><span class="hide-menu">Work
                                            Schedule</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endif


            @endif


            @if (Auth()->User()->can('appuser-list') ||
                    Auth()->User()->can('appuser-create') ||
                    Auth()->User()->can('sysuser-list') ||
                    Auth()->User()->can('sysuser-create'))
                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Users</span>
                </li>

                @if (Auth()->User()->can('sysuser-list') || Auth()->User()->can('sysuser-create') || Auth()->User()->can('assign-shop'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-account-multiple"></i><span class="hide-menu">System Users</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('sysuser-list')
                                <li class="sidebar-item"><a href="{{ route('systemusers.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu">
                                            Manage Sys. Users </span></a>
                                </li>
                            @endcan
                            @can('sysuser-create')
                                <li class="sidebar-item"><a href="{{ route('systemusers.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-account-box"></i> <span class="hide-menu">
                                            Create Sys. Users
                                        </span></a></li>
                            @endcan
                            @can('assign-shop')
                                <li class="sidebar-item"><a href="{{ route('assignshop') }}" class="sidebar-link"><i
                                            class="mdi mdi-account-box"></i> <span class="hide-menu"> Assign Shop
                                        </span></a></li>
                            @endcan

                        </ul>
                    </li>
                @endif

                @if (Auth()->User()->can('appuser-list') || Auth()->User()->can('appuser-create'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="ti-mobile"></i><span
                                class="hide-menu">App Users</span></a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('appuser-list')
                                <li class="sidebar-item"><a href="{{ route('appusers.index') }}"
                                        class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu">
                                            Manage App Users </span></a>
                                </li>
                            @endcan
                            @can('appuser-create')
                                <li class="sidebar-item"><a href="{{ route('appusers.create') }}"
                                        class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu">
                                            Create App. User </span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
            @endif

            @if (Auth()->User()->can('role-list') || Auth()->User()->can('role-create'))
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-anchor"></i><span
                            class="hide-menu">Roles & Rights</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('role-list')
                            <li class="sidebar-item"><a href="{{ route('roles.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-account-key"></i><span class="hide-menu"> Manage Roles </span></a>
                            </li>
                        @endcan
                        @can('role-create')
                            <li class="sidebar-item"><a href="{{ route('roles.create') }}" class="sidebar-link"><i
                                        class="mdi mdi-account-key"></i><span class="hide-menu"> Create Role </span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif


            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    aria-expanded="false"><i class="mdi mdi-directions"></i><span
                        class="hide-menu">{{ __('Logout') }}</span></a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="link"
            data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <!-- End Bottom points-->
</aside>
