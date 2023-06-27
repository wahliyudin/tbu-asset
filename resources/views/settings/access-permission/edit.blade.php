@extends('layouts.master')

@section('title', 'Access Permission')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Data Access Permission
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('settings.access-permission.index') }}" class="text-muted text-hover-primary">
                            Access Permission </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit Access Permission</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formInput" method="POST" action="{{ route('settings.access-permission.update', $user->getKey()) }}">
                @method('PUT')
                @csrf
                <table id="momTable" width="100%" cellpadding="0" cellspacing="0" border="0"
                    class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Main Menu</th>
                            <th>
                                Modul
                            </th>
                            <th colspan="6">Available Fitur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sidebars as $sidebar)
                            @php
                                $total = 0;
                                foreach ($sidebar['children'] as $child) {
                                    $total =
                                        $total +
                                        collect($child['permissions'])
                                            ->pluck('assigned')
                                            ->sum();
                                }
                            @endphp
                            <tr>
                                <td rowspan="{{ count($sidebar['children']) + 1 }}">
                                    <div class="form-check">
                                        <input class="form-check-input checkall_modul"
                                            {{ $total >= count($sidebar['children']) ? 'checked' : '' }} type="checkbox"
                                            value="{{ $sidebar['name'] }}" name="menu" id="menu{{ $sidebar['name'] }}" />
                                        <label class="form-check-label" for="menu{{ $sidebar['name'] }}">
                                            {{ $sidebar['title'] }}
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($sidebar['children'] as $children)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input checkall_fitur {{ $sidebar['name'] }}"
                                                {{ collect($children['permissions'])->pluck('assigned')->sum() > 0? 'checked': '' }}
                                                type="checkbox" value="{{ $sidebar['name'] }}" name="modul[]"
                                                id="modul[]{{ $children['title'] }}" />
                                            <label class="form-check-label" for="modul[]{{ $children['title'] }}">
                                                {{ $children['title'] }}
                                            </label>
                                        </div>
                                    </td>
                                    @foreach ($children['permissions'] as $permission)
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input fitur sub_{{ $sidebar['name'] }}"
                                                    {{ $permission->assigned ? 'checked' : '' }}
                                                    data-modulid="{{ $sidebar['name'] }}" type="checkbox"
                                                    value="{{ $permission->getKey() }}" name="permissions[]"
                                                    id="permissions[]{{ $permission->getKey() . $permission->display }}" />
                                                <label class="form-check-label"
                                                    for="permissions[]{{ $permission->getKey() . $permission->display }}">
                                                    {{ $permission->display }}
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/pages/setting/access-permission/edit.js') }}"></script>
@endpush
