@extends('admin.layouts.main')
<!-- Page Title -->
@section('title', 'الطلاب')

<!-- Header Nav Title -->
@section('nav', 'الرئيسية')

<!-- Header SubNav Title -->
@section('sub_nav', 'الطلاب')

<!-- Content -->
@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table custom-table m-0">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Sessions</th>
                                <th>Users</th>
                                <th>Price</th>
                                <th>Sessions</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>74%<br><small>of Total:<br>80.00% (10)</small></td>
                                <td>57%<br><small>Avg for View:<br>90.00% (-16.67%)</small></td>
                                <td>32%<br><small>Avg for View:<br>50.00% (70.00%)</small></td>
                                <td>35.32<br><small>Avg for View:<br>2.70 (75.93%)</small></td>
                                <td>79<br><small>Avg for View:<br>0.00% (0.00%)</small></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>1. USA</td>
                                <td>327</td>
                                <td>229</td>
                                <td>$139.85</td>
                                <td>21.55%</td>
                                <td>USD 980</td>
                                <td>
                                    <div class="td-actions">
                                        <a href="#" class="icon red" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Add Row">
                                            <i class="icon-circle-with-plus"></i>
                                        </a>
                                        <a href="#" class="icon green" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Save Row">
                                            <i class="icon-save"></i>
                                        </a>
                                        <a href="#" class="icon blue" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Delete Row">
                                            <i class="icon-cancel"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2. India</td>
                                <td>578</td>
                                <td>375</td>
                                <td>$89,319</td>
                                <td>46.90%</td>
                                <td>USD 887</td>
                                <td>
                                    <div class="td-actions">
                                        <a href="#" class="icon red" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Add Row">
                                            <i class="icon-circle-with-plus"></i>
                                        </a>
                                        <a href="#" class="icon green" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Save Row">
                                            <i class="icon-save"></i>
                                        </a>
                                        <a href="#" class="icon blue" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Delete Row">
                                            <i class="icon-cancel"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3. Australia</td>
                                <td>126</td>
                                <td>845</td>
                                <td>$68.00</td>
                                <td>16.25%</td>
                                <td>USD 685</td>
                                <td>
                                    <div class="td-actions">
                                        <a href="#" class="icon red" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Add Row">
                                            <i class="icon-circle-with-plus"></i>
                                        </a>
                                        <a href="#" class="icon green" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Save Row">
                                            <i class="icon-save"></i>
                                        </a>
                                        <a href="#" class="icon blue" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="Delete Row">
                                            <i class="icon-cancel"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
