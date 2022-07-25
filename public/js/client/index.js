var ClientsFunctions = function () {
    const COL_CODE = 0
    const COL_NAME = 1
    const COL_ACTIONS = 2

    var pageUrl = "/json/clients"
    var tableBox = $(".client-table-box")
    var clientsTable = $("#clients-table")
    var formBox = $(".client-form-box")
    var formTitle = formBox.find("legend").find("span")
    var formAlert = formBox.find(".alert-box").find("p")
    var formClient = formBox.find(".form-client")
    var historyTab = formClient.find(".client-history")
    var inputId = formClient.find("input[name=id]")
    var inputCode = formClient.find("input[name=code]")
    var inputName = formClient.find("input[name=name]")
    var inputAddress = formClient.find("input[name=address]")
    var inputNumber = formClient.find("input[name=number]")
    var inputAddress2 = formClient.find("input[name=address2]")
    var inputNeighborhood = formClient.find("input[name=neighborhood]")
    var inputReference = formClient.find("input[name=reference]")
    var inputEmail = formClient.find("input[name=email]")
    var inputCel = formClient.find("input[name=cel]")
    var inputPhone = formClient.find("input[name=phone]")
    var tHistory = formClient.find(".table-history").find("tbody")
    var balanceSpan = formClient.find(".table-history").find(".history-balance")
    var emptyClient = {
            id: 0,
            code: "",
            name: "",
            address: "",
            number: 0,
            address2: "",
            neighborhood: "",
            reference: "",
            email: "",
            cel: "",
            phone: ""
        }

    /**************************************
    * FUNÇÕES DA TABELA
    **************************************/
    var initTable = function (options) {
        dataTable = clientsTable.DataTable( {
            language: options.language,
            ajax: {
                url: pageUrl,
                /*data: function ( d ) {
                    d = getFilters()
                    return d
                },*/
                dataSrc: "records"
            },
            columns: [
                { 
                    data: 'code',
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
                    data: null,
                    render: function (data, type, row) {

                        var columnActions = $("<div></div>")

                        var editAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "edit")
                                            .attr("data-id", row.id)
                                            .addClass("edit-client")
                                            .html(
                                                $("<i></i>")
                                                    .addClass("fa fa-pencil")
                                            )
                        columnActions.append(editAction)
                        
                        var deleteAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "remove")
                                            .attr("data-id", row.id)
                                            .addClass("remove-client")
                                            .html(
                                                $("<i></i>")
                                                    .addClass("fa fa-trash")
                                            )
                        columnActions.append(deleteAction)
                        
                        return columnActions.html()
                    }
                },
            ],
            aaSorting: [
                [COL_CODE, "asc"]
            ],
            columnDefs: [
                { 
                    className: "col-actions",
                    targets: [ COL_ACTIONS ]
                }
            ],
            fnDrawCallback: function(data) {
                adjustFormBoxHeight()  
            }
        } )
    }

    var adjustFormBoxHeight = function () {
        if (formBox.height() < tableBox.height()) {
            formBox.css("height", tableBox.height())
        }
    }

    var controlFormAlert = function (options) {
        formAlert.removeClass()
        formAlert.addClass("alert")

        if (options.class) {
            formAlert.addClass(options.class)
        }

        formAlert.text(options.text)
        formAlert.show(1000)
    }

    var fillClient = function (client, history) {
        let id = client.id

        if (id) {
            formTitle.text("Editando cliente #" + id)
            inputId.val(id)
            historyTab.removeClass("disabled")
        } else {
            formTitle.text("Novo cliente")
            inputId.val(0)
            historyTab.addClass("disabled")
        }
        inputCode.val(client.code)
        inputName.val(client.name)
        inputAddress.val(client.address)
        inputNumber.val(client.number)
        inputAddress2.val(client.address2)
        inputNeighborhood.val(client.neighborhood)
        inputReference.val(client.reference)
        inputEmail.val(client.email)
        inputCel.val(client.cel)
        inputPhone.val(client.phone)
        loadHistory(history)
    }

    var clearForm = function () {
        fillClient(emptyClient, [])
    }

    var calculateServiceWeight = function (items) {
        var totalWeight = 0

        $.each(items, function (index, item) {
            totalWeight += Number(item.quantity)
        })

        return Number(totalWeight).formatWeight()
    }

    var calculateServiceTotal = function (items) {
        var total = 0

        $.each(items, function (index, item) {
            total += Number(item.quantity) * Number(item.price)
        })

        return total
    }

    var loadHistory = function (h) {
        var length = h.length
        var balance = 0;
        tHistory.empty()
        if (length === 0) {
            var empty_line = $('<tr></tr')
                                .append($('<td>Nenhum serviço ou pagamento</td>').attr('colspan','4'))
            tHistory.html(empty_line)
        } else {
            $.each(h, function (index, history) {
                if (! history.hasOwnProperty("items")) {
                    balance += Number(history.value);
                    tHistory.append(
                        $('<tr></tr')
                            .addClass('text-success')
                            .append($('<td></td>')
                                .html(history.created_at.formatDate())
                            )
                            .append($('<td></td>')
                                .addClass('text-center')
                                .html('PAGAMENTO')
                            )
                            .append($('<td></td>')
                                .addClass('text-right')
                                .html(Number(history.value).formatPrice())
                            )
                            .append($('<td></td>')
                                .addClass('col-actions')
                                .append(
                                    $('<a></a>')
                                        .attr('href', '#')
                                        .attr('data-id', history.id)
                                        .attr('data-action', 'edit')
                                        .addClass('edit-payment')
                                        .append(
                                            $('<i></i>').addClass('fa fa-pencil')
                                        )
                                )
                            )
                    )
                } else {
                    balance -= calculateServiceTotal(history.items)
                    let qtyItems = history.items.length
                    let itemText = qtyItems > 1 ? qtyItems + " itens" : "1 item"
                    tHistory.append(
                        $('<tr></tr')
                            .addClass('text-danger')
                            .append($('<td></td>')
                                .html(history.created_at.formatDate())
                            )
                            .append($('<td></td>')
                                .html(itemText + " (" + calculateServiceWeight(history.items) + ")")
                            )
                            .append($('<td></td>')
                                .addClass('text-right')
                                .html(Number(calculateServiceTotal(history.items)).formatPrice())
                            )
                            .append($('<td></td>')
                                .addClass('col-actions')
                                .append(
                                    $('<a></a>')
                                        .attr('href', "#")
                                        .attr('data-id', history.id)
                                        .attr('data-action', 'edit')
                                        .addClass('edit-service')
                                        .append(
                                            $('<i></i>').addClass('fa fa-pencil')
                                        )
                                )
                            )
                    )                    
                }
            })
        }
        if (balance < 0) {
            balanceSpan.addClass("text-danger")
        } else if (balance > 0) {
            balanceSpan.addClass("text-success")
        } else {
            balanceSpan.removeClass("text-danger text-success")
        }
        balanceSpan.text(Number(balance).formatPrice())
    }

    var loadClient = function (id) {
        let flag = false
        $.ajax({
            headers: {
                'X-CSRF-Token': window.Laravel.csrfToken
            },
            url: pageUrl + '/' + id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                let options = {
                    class: "alert-info",
                    text: "Carregando cliente..."
                }
                controlFormAlert(options)
            },
            success: function (data) {
                if (data.status) {
                    fillClient(data.record.client, data.record.history)
                    let options = {
                        class: "alert-success",
                        text: "Cliente carregado com sucesso!"
                    }
                    controlFormAlert(options)
                } else {
                    let options = {
                        class: "alert-danger",
                        text: "Erro ao carregar cliente!"
                    }
                    controlFormAlert(options)
                }
            },
            error: function (data) {
                let options = {
                    class: "alert-danger",
                    text: "Erro ao carregar cliente!"
                }
                controlFormAlert(options)
            },
            complete: function () {
                formAlert.hide(1000)
            }
        })
    }

    var removeClient = function (id) {
        if (confirm('Deseja excluir esse registro?')) {
            $.ajax({
                headers: {
                    'X-CSRF-Token': window.Laravel.csrfToken
                },
                url: pageUrl + '/' + id,
                type: 'DELETE',
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        alert('Registro removido com sucesso!\n\nAtualizando a página.')
                    } else {
                        alert('Erro ao remover o registro!\n\nAtualizando a página.')
                    }
                },
                error: function (data) {
                    alert('Erro ao solicitar a remoção do registro ao servidor!\n\nAtualizando a página')
                },
                complete: function () {
                    dataTable.ajax.reload(null, false);
                }
            })
        }
    }

    var getFormData = function () {
        return {
            id: inputId.val(),
            code: inputCode.val(),
            name: inputName.val(),
            address: inputAddress.val(),
            number: inputNumber.val(),
            address2: inputAddress2.val(),
            neighborhood: inputNeighborhood.val(),
            reference: inputReference.val(),
            email: inputEmail.val(),
            cel: inputCel.val(),
            phone: inputPhone.val(),
        }
    }

    var validateClient = function (data) {
        var errors = {}
    
        if (!data.code || data.code.length === 0) {
            errors.code = 'Preencha o campo código'
        }

        if (data.code.length > 20) {
            errors.code = 'Campo código deve ter no máximo 20 caracteres'
        }

        if (!data.name || data.name.length === 0) {
            errors.name = 'Preencha o campo nome'
        }

        if (data.name.length > 80) {
            errors.name = 'Campo código deve ter no máximo 80 caracteres'
        }
        
        return errors;
    }

    var clearErrors = function () {
        $(".has-error").removeClass("has-error")
        let options = {
            class: "",
            text: ""
        }
        controlFormAlert(options)
    }

    var displayErrors = function (errors) {
        if(('code' in errors) || ('name' in errors)){
            alertBox.addClass('alert-danger')
            if ('code' in errors) {
                codeInput.parent().addClass('has-error')
                var errorCode = $('<p></p>').text(errors.code)
                alertBox.append(errorCode)
            }

            if ('name' in errors) {
                nameInput.parent().addClass('has-error')
                var errorName = $('<p></p>').text(errors.name)
                alertBox.append(errorName)
            }
        }
    }

    var saveClient = function (client) {
        clearErrors()
        let options = {
            class: "alert-info",
            text: "Salvando cliente..."
        }
        controlFormAlert(options)

        var method = 'POST'
        var url = pageUrl

        if (client.id != "0") {
            method = 'PUT'
            url += '/' + client.id
        }

        $.ajax({
            headers: {
                'X-CSRF-Token': window.Laravel.csrfToken
            },
            url: url,
            type: method,
            data: client,
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    options.class = "alert-success"
                    options.text = "Cliente salvo com sucesso!"
                } else {
                    options.class = "alert-danger"
                    options.text = "Erro ao salvar cliente!"
                }
            },
            error: function (data) {
                options.class = "alert-danger"
                options.text = "Erro na requisição ao servidor!"
            },
            complete: function () {
                controlFormAlert(options)
                clearForm()
                dataTable.ajax.reload(null, false)
                formAlert.hide(1000)
            }
        })
    }

    /*var clearFormPayment = function () {
        boxPaymentLoading.addClass('hidden')
        boxPayment.addClass('hidden')
        idPaymentInput.val(0)
        valueInput.val(0)
        boxPayment.find('.form-title').text('Novo pagamento')
        alertBoxPayment.removeClass("alert-success")
        alertBoxPayment.removeClass("alert-danger")
        alertBoxPayment.empty()
    }

    var fillPayment = function (payment) {
        idPaymentInput.val(payment.id)
        valueInput.val(Number(payment.value))
        boxPayment.find('.form-title').text('Editando pagamento #' + payment.id)   
        boxPayment.removeClass('hidden')
        boxPaymentLoading.addClass('hidden')
    }
    
    var getFormPaymentData = function () {
        return {
            client_id: idInput.val(),
            payment_id: idPaymentInput.val(),
            value: valueInput.val()
        }
    }

    var validatePayment = function (payment) {
        var value = payment.value
        if (! value || value != Number(value)) {
            return false
        }

        return true
    }

    var savePayment = function (payment, payment_id) {
        var msgPayment = $('<p></p>')
            .html('<i class="fa fa-spinner fa-spin"></i> Pagamento validado! Salvando...')
        alertBoxPayment.addClass('alert-info')
        alertBoxPayment.append(msgPayment)

        var method = 'POST'
        var url = pageUrl + '/payment'

        if (payment_id) {
            method = 'PUT'
            url += '/' + payment_id
        } 

        $.ajax({
            headers: {
                'X-CSRF-Token': window.Laravel.csrfToken
            },
            url: url,
            type: method,
            data: payment,
            dataType: 'json',
            success: function (data) {
                alertBoxPayment.removeClass('alert-info')
                alertBoxPayment.empty()
                if (data.status) {
                    msgPayment = $('<p></p>').text('Pagamento salvo com sucesso')
                    alertBoxPayment.addClass('alert-success')
                    alertBoxPayment.html(msgPayment)
                    alert('Pagamento salvo com sucesso')
                } else {
                    msgPayment = $('<p></p>').text('Erro ao salvar pagamento')
                    alertBoxPayment.addClass('alert-danger')
                    alertBoxPayment.html(msgPayment)
                    alert('Erro ao salvar pagamento')
                }
            },
            error: function (data) {
                msg = $('<p></p>').text('Erro na solicitação ao servidor!')
                alertBox.addClass('alert-danger')
                alertBox.html(msg)
                alert('Erro na solicitação ao servidor!')
            },
            complete: function () {
                clearFormPayment()
                loadClient(idInput.val())
                alert('Recarregando cliente...')
            }
        })
    }

    var loadPayment = function (payment_id) {
        $.ajax({
            headers: {
                'X-CSRF-Token': window.Laravel.csrfToken
            },
            url: pageUrl + '/payment/' + payment_id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                clearFormPayment()
                boxPaymentLoading.removeClass('hidden')
            },
            success: function (data) {
                if (data.status) {
                    fillPayment(data.record)
                } else {
                    alert('Erro ao carregar pagamento!\n\nAtualizando a página.')
                    window.location.reload();
                }
            },
            error: function (data) {
                alert('Erro na requisição ao servidor!\n\nAtualizando a página.')
                window.location.reload();
            }
        })
    }

    var displayErrorsPayment = function () {
        alertBoxPayment.addClass('alert-danger')
        alertBoxPayment.html($('<p></p>').text('Valor inválido!'))
        valueInput.parent().addClass('has-error')
    }*/

    var handleButtons = function () {
        $('.phone').mask('(00) 0000-0000', {placeholder: '(99) 9999-9999',});

        var options =  {
            placeholder: '(99) 99999-9999',
            onKeyPress: function(cel, e, field, options) {
                var masks = ['(00) 0000-00009', '(00) 00000-0000'];
                var mask = (cel.length > 14) ? masks[1] : masks[0];
                field.mask(mask, options);
            }
        };

        $('.cel').mask('(00) 0000-00009', options);

        var domDocument = $(document)

        domDocument.on('click', '.edit-client', function (e) {
            e.preventDefault()

            var id = $(this).data('id')
            loadClient(id)
        })

        domDocument.on('click', '.remove-client', function (e) {
            e.preventDefault()

            var id = $(this).data('id')
            removeClient(id)
        })

        domDocument.on('click', '.btn-clear', function (e) {
            e.preventDefault()
            clearForm()
        })

        domDocument.on('submit', '.form-client', function (e) {
            e.preventDefault()

            clearErrors()

            var client = getFormData()
            var errors = validateClient(client)

            if (Object.keys(errors).length === 0) {
                saveClient(client)
            } else {
                displayErrors(errors)
            }
        })            
    }

    return {
        init: function () {
            //getRecords(pageUrl, 1)
            handleButtons()
            $.get('/json/lang/datatable')
                .done(function(data) {
                    initTable({
                        language: data
                    })
                })
                .fail(function() {
                    initTable({})
                })
        }
    }
}()

$(document).ready(function () {
    ClientsFunctions.init();
})