var ItemFunctions = function () {

    var pageUrl = "/json/items"
    var itemsTable = $("#item-table")
    var dataTable
    var priceInputs = $(".input-price")
    var clearFormButton = $(".btn-clear-form")
    var form = $("form")
    var formTitle = form.find(".form-title")
    var formFields = {
        id: form.find("input[name=id]"),
        name: form.find("input[name=name]"),
        values: {
            laundry: form.find("input[name='values[laundry_price]']"),
            ironing: form.find("input[name='values[ironing_price]']"),
            both: form.find("input[name='values[both_price]']")
        }
    }
    var formAlertBox = form.find(".form-alert-box")

    var setFormMessage = function (msg, className = "info") {
        var alert = $("<p></p>")
                        .addClass("alert alert-" + className)
                        .text(msg)

        alert.html(alert.html().replace(/\n/g,'<br/>'))

        formAlertBox.html(alert)
    }

    var hideAlerts = function () {
        formAlertBox.empty()
    }

    var handleButtons = function () {
        // BOTÕES DO FORMULÁRIO
        form.on("submit", function (e) {
            e.preventDefault()
            sendForm()
        })

        clearFormButton.click(function () {
            clearForm()
        })

        // BOTÕES DA LISTAGEM
        $(document).on("click", ".edit-record", function (e) {
            e.preventDefault()
            var id = $(this).data("id")

            $.ajax({
                url: pageUrl + "/" + id,
                type: "GET",
                dataType: "json",
                beforeSend: function () {
                    hideAlerts()
                    setFormMessage("Carregando item...")
                },
                success: function (data) {
                    if (data.status) {
                        var item = data.record
                        var values = item.values[0]
                        loadForm(item.id, item.name, values.laundry_price, values.ironing_price, values.both_price)
                    }
                    hideAlerts()
                },
                error: function (data) {
                    setFormMessage("Erro ao carregar item!", "danger")
                }
            })
        })

        $(document).on("click", ".remove-record", function(e) {
            e.preventDefault

            var id = $(this).data("id")
            if (confirm("Deseja excluir esse registro?")) {
                $.ajax({
                    headers: {
                        "X-CSRF-Token": $("input[name=_token]").val()
                    },
                    url: pageUrl + "/" + id,
                    type: "DELETE",
                    dataType: "json",
                    success: function (data) {
                        if (data.status) {
                            alert("Registro removido com sucesso!\n\nAtualizando listagem.")
                        } else {
                            alert("Erro ao remover o registro!\n\nAtualizando listagem.")
                        }
                    },
                    error: function (data) {
                        alert("Erro ao solicitar a remoção do registro ao servidor!\n\nAtualizando listagem")
                    },
                    complete: function() {
                        dataTable.ajax.reload(null, false)
                    }
                })
            }
        })
    }

    /**************************************
    * FUNÇÕES DO FORMULÁRIO
    **************************************/
    var loadMasks = function () {
        priceInputs.mask("00.00", {reverse: true})
    }

    var clearForm = function () {
        hideAlerts()
        loadForm()
    }

    var validate = function (data) {
        setFormMessage("Validando formulário...")
        var errors = {}

        if (!data.name || data.name.length === 0) {
            errors.name = "Preencha o campo nome"
        }

        if (data.name.length > 80) {
            errors.name = "Campo código deve ter no máximo 80 caracteres"
        }

        if (data.values) {
            var laundryPrice = data.values.laundry_price
            var ironingPrice = data.values.ironing_price
            var bothPrice = data.values.both_price

            if (laundryPrice !== undefined) {
                if (laundryPrice != Number(laundryPrice)) {
                    errors.values = {
                        laundry_price: "Valor inválido para o preço de lavar"
                    }
                }
            }

            if (ironingPrice !== undefined) {
                if (ironingPrice != Number(ironingPrice)) {
                    if (errors.values) {
                        errors.values.ironing_price = "Valor inválido para o preço de passar"
                    } else {
                        errors.values = {
                            ironing_price: "Valor inválido para o preço de passar"
                        }       
                    }
                }
            }

            if (bothPrice !== undefined) {
                if (bothPrice != Number(bothPrice)) {
                    if (errors.values) {
                        errors.values.both_price = "Valor inválido para o preço de lavar e passar"
                    } else {
                        errors.values = {
                            both_price: "Valor inválido para o preço de lavar e passar"
                        }       
                    }
                }
            }
        } else {
            errors.values = "Erro ao recuperar os valores"
        }
        
        return errors
    }

    var displayErrors = function (errors) {
        var errorsMsg = ''

        if (errors.name) {
            errorsMsg += 'NOME => ' + errors.name + '\n\n'
        }

        if (errors.values) {
            var errorsValues = errors.values
            errorsMsg += 'PREÇOS: \n\n'

            if (errorsValues.laundry_price) {
                errorsMsg += '   - LAVAR: ' + errorsValues.laundry_price + '\n\n'
            }

            if (errorsValues.ironing_price) {
                errorsMsg += '   - PASSAR: ' + errorsValues.ironing_price + '\n\n'
            }

            if (errorsValues.both_price) {
                errorsMsg += '   - AMBOS: ' + errorsValues.both_price + '\n\n'
            }
        }

        return errorsMsg
    }

    var loadForm = function (id, name = "", laundry_price, ironing_price, both_price) {
        if (id) {
            formTitle.text("Editando item #" + id)
        } else {
            formTitle.text("Novo item")
        }

        if (isNaN(id)) {
            id = 0
        }

        if (isNaN(laundry_price)) {
            laundry_price = ""
        }

        if (isNaN(ironing_price)) {
            ironing_price = ""
        }

        if (isNaN(both_price)) {
            both_price = ""
        }

        formFields.id.val(id)
        formFields.name.val(name)
        formFields.values.laundry.val(laundry_price)
        formFields.values.ironing.val(ironing_price)
        formFields.values.both.val(both_price)
    }

    var getFormData = function () {
        var laundry_price = formFields.values.laundry.val()
        var ironing_price = formFields.values.ironing.val()
        var both_price = formFields.values.both.val()
        var formData = {
            id: formFields.id.val(),
            name: formFields.name.val(),
            values: {
                laundry_price: laundry_price  && ! isNaN(laundry_price) ? laundry_price : 0,
                ironing_price: ironing_price  && ! isNaN(ironing_price) ? ironing_price : 0,
                both_price: both_price  && ! isNaN(both_price) ? both_price : 0
            }
        }
        
        return formData  
    }

    var sendForm = function () {
        var formData = getFormData()
        var errors = validate(formData)

        if (Object.keys(errors).length === 0) {
            setFormMessage("Formulário validado!\nEnviando dados...")

            var method = "POST"
            var url = pageUrl
            if (formData.id != 0) {
                method = "PUT"
                url +=  "/" + formData.id
            }
            
            $.ajax({
                headers: {
                    "X-CSRF-Token": $("input[name=_token]").val()
                },
                url: url,
                type: method,
                data: formData,
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        setFormMessage("Dados enviados com sucesso!\n\nAtualizando listagem.", "success")
                    } else {
                        setFormMessage("Erro ao salvar item!\n\nAtualizando listagem.", "danger")
                    }
                },
                error: function () {
                    setFormMessage("Erro na requisição ao servidor!\n\nAtualizando listagem.", "danger")
                },
                complete: function () {
                    setTimeout(function () {
                        clearForm()
                        dataTable.ajax.reload(null, false)
                    }, 350)
                }
            })
        } else {
            setFormMessage("Dados inválidos!\n\n" + displayErrors(errors), "danger")
        }
    }
    /**************************************
    * FUNÇÕES DA TABELA
    **************************************/
    var initTable = function (language) {

        dataTable = itemsTable.DataTable( {
            ajax: {
                url: pageUrl,
                dataSrc: 'records'
            },
            columns: [
                { 
                    data: 'id',
                    render: function (data, type, row) {
                        return data
                    }
                },
                { 
                    data: 'name',
                    render: function (data, type, row) {
                        return data
                    }
                },
                { 
                    data: 'values.0.laundry_price',
                    render: function (data, type, row) {
                        return Number(data).formatPrice()
                    }
                },
                { 
                    data: 'values.0.ironing_price',
                    render: function (data, type, row) {
                        return Number(data).formatPrice()
                    }
                },
                { 
                    data: 'values.0.both_price',
                    render: function (data, type, row) {
                        return Number(data).formatPrice()
                    }
                },
                { 
                    data: null,
                    render: function (data, type, row) {
                        var columnActions = $("<div></div>")
                        var editAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "edit")
                                            .attr("data-id", row.id)
                                            .addClass("edit-record")
                                            .html(
                                                $("<i></i>")
                                                    .addClass("fa fa-pencil")
                                            )
                        
                        var deleteAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "remove")
                                            .attr("data-id", row.id)
                                            .addClass("remove-record")
                                            .html(
                                                $("<i></i>")
                                                    .addClass("fa fa-trash")
                                            )
                        columnActions.append(editAction).append(deleteAction)
                        
                        return columnActions.html()
                    }
                },
            ],
            columnDefs: [
                { className: "col-actions", targets: [ 5 ] }
            ],
            language: language
        } )
    }

    return {
        init: function () {
            loadMasks()
            handleButtons()
            $.get('/json/lang/datatable')
                .done(function(data) {
                    initTable(data)
                })
                .fail(function() {
                    initTable({})
                })
        }
    }
}()

$(document).ready(function () {
    ItemFunctions.init()
})