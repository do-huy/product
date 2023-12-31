var variantIndex = 0
var isFirstRender = true
/**
 * Array<{ options: string, price: number, comparative_price: number, quantity: number, sku: string }>
 */
var productItemCache = []
$(function () {
    OLD_PRODUCT_ITEMS.forEach(item => {
        const firstOption = (OLD_VARIANTS[0]?.options || [])
            .find(op => item.options.includes(op))

        productItemCache.push({
            // image: item?.image,
            image: firstOption ? (OLD_VARIANT_OPTION_IMAGE[firstOption]?.url || null) : null,
            id: item?.id,
            options: item.options,
            price: item.price,
            comparative_price: item.comparative_price,
            quantity: item.quantity,
            sku: item.sku
        })
    })

    OLD_VARIANTS.forEach(ov => {
        if (!ov?.options) {
            ov.options = []
        }
        ov.options.push('')
    })
    for (var variant of OLD_VARIANTS) {
        addVariantGroup(variant)
    }

    Object.keys(OLD_VARIANT_OPTION_IMAGE).forEach(option => {
        $('#old-images-box').append(
            `<input type="text" name="variant_old_files[${option}]" value="${OLD_VARIANT_OPTION_IMAGE[option]?.path || ''}"/>`
        );
    })

    renderProductItemTable()
    isFirstRender = false
    clearErrors();

    // change before submit
    $('#product-form').submit(function () {
        $('.variant-option-box').each(function () {
            $('.variant-option', $(this).children().last()).removeAttr('name')
            $('.variant-option-id', $(this).children().last()).removeAttr('name')

        });

        $('.variant-option', $('.variant-group')[0]).each(function (index) {
            if (!$(this).attr('name')) {
                return false;
            }

            $(`.variant-file:eq(${index})`).attr('name', `variant_files[${$(this).val()}]`)
        })

        return true
    })
});
// $(document).ready(function () {

// })

const addVariantGroup = (variant) => {
    $('#variant-box').append(createVariantGroupElement(variant?.name, variant?.options))
    variantIndex++
    if (!isFirstRender) {
        productItemCache = []
        renderProductItemTable()
    }
}

const createVariantGroupElement = (name = '', options = []) => `<div class="card variant-group">
    <button type="button" class="material-icons-sharp font-size-inherit remove-variant-item" onclick="removeVariantGroup(this)">
        close
    </button>
    <div class="card-body variant-item">
        <div class="form-group row">
            <label class="col-2 bmd-label-floating col-form-label">Nhóm phân loại:</label>
            <div class="col">
                ${loadVariantIndexInputElement(variantIndex)}
                <input type="text" name="variants[${variantIndex}][name]"
                    class="form-control variant-name" value="${name || ''}" oninput="renderProductItemTable()">
                ${loadVariantNameError(variantIndex)}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-2 bmd-label-floating col-form-label">Phân loại hàng:</label>
            <div class="col-sm-10 form-row variant-option-box">
                ${renderManyVariantOptionsElement(variantIndex, options)}
            </div>
        </div>
    </div>
</div>`

const renderManyVariantOptionsElement = (variantIndex, options) => {
    options = !options.length ? [''] : options

    return options
        .map((option, optionIndex) => renderVariantOptionElement(variantIndex, optionIndex, option))
        .join('')
}

const removeVariantGroup = (element) => {
    $('#input-file-box').empty()
    $(element).parent().remove()
    productItemCache = []
    renderProductItemTable()
}

const renderVariantOptionElement = (variantIndex, optionIndex, option = '') => `<div class="col-auto mb-2">
    <div class="input-group">
        ${loadVariantOptionIdInputElement(variantIndex, optionIndex)}
        <input type="text" name="variants[${variantIndex}][options][]"
            class="form-control variant-option" value="${option || ''}" oninput="changeVariantOption(this, ${variantIndex})">
        <div class="input-group-append" onclick="removeVariantOptionValue(this)">
            <div class="input-group-text">
                <span class="material-icons-sharp font-size-inherit">
                    backspace
                </span>
            </div>
        </div>
    </div>
    ${loadVariantOptionError(variantIndex, optionIndex)}
</div>`

const changeVariantOption = (element, variantIndex) => {
    renderProductItemTable()
    const variantOptionBox$ = $(element).closest('.variant-option-box')
    if ($.trim($(element).val()) && $(element).is($('.variant-option', variantOptionBox$.children().last()))) {
        variantOptionBox$.append(renderVariantOptionElement(variantIndex))
    }
}

const removeVariantOptionValue = (element) => {
    const variantGroup$ = $(element).closest('.variant-group')
    if (variantGroup$.is($('#variant-box').children().first())) {
        removeFileInputWithIndex($('.input-group-append', variantGroup$).index(element))
    }

    $(element).parents().get(1).remove()

    renderProductItemTable()
}

const renderProductItemTable = () => {
    $('#product-item-table thead tr').html('')
    $('#product-item-table tbody').html('')
    $('#product-item-box').hide()
    const variantGroups = $('.variant-group')
        .map(function () {
            const variantGroup$ = $(this)
            const variantName = $.trim($('.variant-name', variantGroup$).val())
            const variantOptions = $('.variant-option', variantGroup$)
                .map(function () {
                    return $.trim($(this).val())
                })
                .get()
                .filter((variantOption) => variantOption)

            return { name: variantName, options: !variantOptions.length ? [''] : variantOptions }
        })
        .get()

    // .filter(
    //     (variantGroup) => variantGroup.name
    //         && variantGroup.options.length
    // )

    makeProductItemTable(variantGroups)

    if (variantGroups.length) {
        rerenderInputFileBox(variantGroups[0].options)
    }
}

const makeProductItemTable = (variantGroups) => {
    if (!variantGroups.length) {
        return
    }

    $('#product-item-box').show()
    const thead = variantGroups.map(vg => `<th>${vg.name}</th>`).join('') + renderBaseHeaderElement()
    const tbody = renderTbodyElement(variantGroups)
    $('#product-item-table thead tr').html(thead)
    $('#product-item-table tbody').html(tbody)
}

const renderBaseHeaderElement = () => `<th>Giá</th>
    <th>Giá tham chiếu</th>
    <th>Số lượng</th>
    <th>SKU phân loại</th>`

const renderTbodyElement = (variantGroups) => {
    const combinationVariants = renderCombineVariantArray(variantGroups)
    const rowSpan = variantGroups.reduce(
        (acc, cur, index) => index !== 0 ? acc * cur.options.length : acc,
        1
    )

    return combinationVariants.map((options, rowIndex) => {
        const tds = options.map((option, optionIndex) => {
            if (optionIndex === 0) {
                return rowIndex % rowSpan === 0 ? renderFirstTdElement(option, rowSpan, rowIndex) : ''
            }

            return renderVariantOptionTdElement(option, rowIndex)
        })

        return `<tr>${tds.join('')}${renderBaseRowElement(rowIndex, options)}</tr>`
    }).join('')
}

const renderFirstTdElement = (variantOption, rowSpan, rowIndex) => `<td class="variant-option-cell" rowspan="${rowSpan}">
    ${rangeInteger(rowIndex, rowSpan + rowIndex)
        .map(r => renderProductItemVariantOptionInput(r, variantOption))
        .join('')}
    <p>${variantOption}</p>
    ${renderImagePreviewElement(rowIndex)}
</td>`

const renderVariantOptionTdElement = (variantOption, rowIndex) => `<td class="variant-option-cell">
    ${renderProductItemVariantOptionInput(rowIndex, variantOption)}
    <p>${variantOption}</p>
</td>`

const renderProductItemVariantOptionInput = (rowIndex, variantOption) => `<input type="text" class="hidden"
name="product_items[${rowIndex}][options][]" value="${variantOption}"/>
`

const renderBaseRowElement = (rowIndex, options) => {
    const item = loadCacheProductItem(options);

    return `<td>
        <div class="form-row align-items-center">
            ${loadProductItemIdInputElement(rowIndex)}
            <div class="col-auto mb-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <div class="input-group-text">đ</div>
                    </div>
                    <input type="number" name="product_items[${rowIndex}][price]" value="${item?.price || ''}"
                        onchange='cacheProductItem(this, "price", ${JSON.stringify(options)})' class="form-control">
                </div>
                ${loadProductItemPriceError(rowIndex)}
            </div>
            </div>
        </td>
        <td>
            <div class="form-row align-items-center">
                <div class="col-auto mb-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text">đ</div>
                        </div>
                        <input type="number" name="product_items[${rowIndex}][comparative_price]" value="${item?.comparative_price || ''}"
                            onchange='cacheProductItem(this, "comparative_price", ${JSON.stringify(options)})' class="form-control">
                    </div>
                    ${loadProductItemComparativePriceError(rowIndex)}
                </div>
            </div>
        </td>
        <td>
            <div class="form-row align-items-center">
                <div class="col-auto mb-2">
                    <div class="input-group input-group-sm">
                        <input type="number" name="product_items[${rowIndex}][quantity]" value="${item?.quantity || 0}"
                            onchange='cacheProductItem(this, "quantity", ${JSON.stringify(options)})' class="form-control">
                    </div>
                    ${loadProductItemQuantityError(rowIndex)}
                </div>
            </div>
        </td>
        <td>
            <div class="form-row align-items-center">
                <div class="col-auto mb-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="product_items[${rowIndex}][sku]" value="${item?.sku || ''}"
                            onchange="cacheProductItem(this, 'sku', '${JSON.stringify(options)}')" class="form-control">
                    </div>
                </div>
            </div>
        </td>`
}

const renderCombineVariantArray = (variants) => {
    var combinations = []
    combineVariants(variants, 0, [], combinations)

    return combinations
}

const combineVariants = (variants, currentVariantIndex, currentCombination, combinations) => {
    if (currentVariantIndex === variants.length) {
        combinations.push(currentCombination.slice())
        return
    }

    const currentVariantOptions = variants[currentVariantIndex].options

    for (let i = 0; i < currentVariantOptions.length; i++) {
        currentCombination[currentVariantIndex] = currentVariantOptions[i]

        combineVariants(variants, currentVariantIndex + 1, currentCombination, combinations)
    }
}

const rangeInteger = (start, stop) => Array.from({ length: (stop - start) }, (value, index) => start + index)

const cacheProductItem = (element, field, options) => {
    if (options === '') {
        return
    }
    const pItem = loadCacheProductItem(options)
    if (!pItem) {
        productItemCache.push({ options, [field]: $(element).val() })
    } else {
        pItem[field] = $(element).val()
    }
}

const loadCacheProductItem = (options) => productItemCache.find(item => isEqual(item.options, options))

const rerenderInputFileBox = (variantOptions) => {
    const totalInputFile = $('.variant-file').length
    if (totalInputFile < variantOptions.length) {
        for (var i = totalInputFile; i < variantOptions.length; i++) {
            $('#input-file-box').append(renderInputFileElement())
        }
    }

    if (!isFirstRender) {
        previewAllImage()
    }
}

const renderInputFileElement = () => `<input class="variant-file" type="file" name="variant_files[]" onchange="handleChangeFileInput(this)"
    accept="image/*" multiple="false"" />`
const removeFileInputWithIndex = (index) => {
    if ($('#input-file-box input').length > 1) {
        $(`#input-file-box > input:eq(${index})`).remove()
    }
}

const clickToFileInput = (element) => {
    if ($(element).hasClass('has-image')) {
        return
    }

    const inputIndex = $(element).closest('tr').index() / Number($(element).closest('td').attr('rowspan'))
    const input = $(`#input-file-box > input:eq(${inputIndex})`)

    if (input.length) {
        input.click()
    }
}

const handleChangeFileInput = (input) => {
    const previewIndex = $('#input-file-box > input').index(input)

    removeOldFile(previewIndex);
    previewImage(input);
}

const previewImage = (input) => {
    const previewIndex = $('#input-file-box > input').index(input)
    const image$ = $('.product-item-image').eq(previewIndex)

    if (!image$.length) {
        return
    }

    const file = input?.files && input?.files[0] ? input.files[0] : null;
    const oldFile = getOldFile(previewIndex)

    if (file) {
        $(image$.parents().get(0)).addClass('has-image')
        image$.attr('src', window.URL.createObjectURL(file))
    } else if (oldFile) {
        $(image$.parents().get(0)).addClass('has-image')
        image$.attr('src', oldFile)
    } else {
        $(image$.parents().get(0)).removeClass('has-image')
        image$.attr('src', DEFAULT_IMAGE)
    }
}

const getOldFile = (previewIndex) => {
    const option = $(`.variant-group:eq(0) .variant-option:eq(${previewIndex})`).val();
    return oldFile = option && OLD_VARIANT_OPTION_IMAGE[option]
        ? OLD_VARIANT_OPTION_IMAGE[option]?.url
        : null
}

const removeOldFile = (index) => {
    const option = $(`.variant-group:eq(0) .variant-option:eq(${index})`).val();
    delete OLD_VARIANT_OPTION_IMAGE[option];
    const oldImageInput = $(`#old-images-box > input[name="variant_old_files[${option}]"]`);
    if (oldImageInput.length) {
        oldImageInput.remove();
    }
}

const previewAllImage = () => {
    $('#input-file-box > input').each(function () {
        previewImage(this)
    })
}
const removeImage = (event, element) => {
    const inputIndex = $(element).closest('tr').index() / Number($(element).closest('td').attr('rowspan'))
    const input = $(`#input-file-box > input:eq(${inputIndex})`)
    if (input.length) {
        input.val('')
        input.change()
    }

    removeOldFile(inputIndex);

    event.stopPropagation()
}

const loadVariantNameError = (index) => buildErrorElement(VALIDATOR_ERRORS.variant.name[`variants.${index}.name`] ?? null);
const loadVariantOptionError = (variantIndex, optionIndex) => {
    let message = null;
    if (optionIndex === 0) {
        message = VALIDATOR_ERRORS.variant.firstOptionErrors[`variants.${variantIndex}.options`]
    }

    return buildErrorElement(
        message ?? VALIDATOR_ERRORS.variant.option[`variants.${variantIndex}.options.${optionIndex}`] ?? null
    );
}
const loadProductItemPriceError = (index) => buildErrorElement(VALIDATOR_ERRORS.productItem.price[`product_items.${index}.price`])
const loadProductItemComparativePriceError = (index) => buildErrorElement(VALIDATOR_ERRORS.productItem.comparative_price[`product_items.${index}.comparative_price`])
const loadProductItemQuantityError = (index) => buildErrorElement(VALIDATOR_ERRORS.productItem.quantity[`product_items.${index}.quantity`])

const buildErrorElement = (message) => message
    ? `<span class="text-danger">
        <span class="mess-error"><i class="fas fa-exclamation-triangle"></i>
            ${message}
        </span>
    </span>`
    : ''

const clearErrors = () => {
    VALIDATOR_ERRORS.variant.name = {};
    VALIDATOR_ERRORS.variant.option = {};
    VALIDATOR_ERRORS.productItem.price = {};
    VALIDATOR_ERRORS.productItem.comparative_price = {};
    VALIDATOR_ERRORS.productItem.quantity = {};
}

const loadVariantIndexInputElement = (variantIndex) => {
    const id = OLD_VARIANTS[variantIndex]?.id;

    return id
        ? `<input type="text" class="hidden" name="variants[${variantIndex}][id]" value="${id}" />`
        : ''
}

const loadVariantOptionIdInputElement = (variantIndex, optionIndex) => {
    let id = null;
    if (OLD_VARIANTS[variantIndex]?.option_ids) {
        id = OLD_VARIANTS[variantIndex]?.option_ids[optionIndex] || null
    }

    return `<input type="text" class="hidden variant-option-id" name="variants[${variantIndex}][option_ids][]" value="${id || ''}" />`
}

const loadProductItemIdInputElement = (rowIndex) => {
    const id = productItemCache[rowIndex]?.id;
    return id
        ? `<input type="text" class="hidden" name="product_items[${rowIndex}][id]" value="${id}" />`
        : ''
}

const renderImagePreviewElement = (rowIndex) => {
    const image = productItemCache[rowIndex]?.image;

    return `<div onclick="clickToFileInput(this)" class="${image ? 'has-image' : ''}">
        <img class="product-item-image" src="${image || DEFAULT_IMAGE}" alt="" onerror="this.src='${DEFAULT_IMAGE}'" />
        <span class="material-icons-sharp color-red remove-image-icon" onclick="removeImage(event,this)">
            close
        </span>
    </div>`
}

const isEqual = (array1, array2) => {
    if (array1.length === array2.length) {
        return array1.every(element => {
            if (array2.includes(element)) {
                return true;
            }

            return false;
        });
    }

    return false;
}
