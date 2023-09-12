<tr data-repeater-item>
    <td>
        <input type="hidden" name="asset" class="asset">
        <input type="text" @readonly($type == 'show') value="{{ $cerItem->description }}" name="description"
            class="form-control asset-description">
    </td>
    <td>
        <input type="text" @readonly($type == 'show') value="{{ $cerItem->model }}" name="model"
            class="form-control asset-model">
    </td>
    <td>
        <div class="input-group">
            <input type="number" @readonly($type == 'show') value="{{ $cerItem->est_umur }}" name="est_umur" min="1"
                class="form-control umur-asset">
            <span class="input-group-text">Bulan</span>
        </div>
    </td>
    <td id="uom">
        <select @disabled($type == 'show') class="form-select" name="uom_id">
            <option value="">-Select-</option>
            @if ($type == 'show')
                <option selected>{{ $cerItem->uom?->name }}</option>
            @else
                @foreach ($uoms as $uom)
                    <option @selected($cerItem->uom_id == $uom->id) value="{{ $uom->id }}">{{ $uom->name }}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td>
        <input type="number" readonly value="1" name="qty" min="1" class="form-control qty">
    </td>
    <td>
        <input type="text" value="{{ \App\Helpers\Helper::formatRupiah($cerItem->price) }}" name="price"
            @readonly($type == 'show') class="form-control uang price">
    </td>
    <td>
        <input type="text" readonly value="{{ \App\Helpers\Helper::formatRupiah($cerItem->qty * $cerItem->price) }}"
            class="form-control uang sub-total">
    </td>
    @if ($type != 'show')
        <td>
            <div class="d-flex align-items-center gap-1">
                <button type="button" btn-asset class="btn btn-sm btn-primary ps-3 pe-2">
                    <i class="ki-duotone ki-lots-shopping fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                        <i class="path4"></i>
                        <i class="path5"></i>
                        <i class="path6"></i>
                        <i class="path7"></i>
                        <i class="path8"></i>
                    </i>
                </button>
                <button type="button" data-repeater-delete class="btn btn-sm btn-danger ps-3 pe-2">
                    <i class="ki-duotone ki-trash fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </button>
            </div>
        </td>
    @endif
</tr>
