var PaymentFunctions = function () {

	const SHOW_MODAL = "show"
	const HIDE_MODAL = "hide"

	var pageUrl = "/json/clients/payment"
	var modalPayment = $("#modal-payment")
	var overflow = modalPayment.find(".modal-message-overflow")
	var overflowMsg = overflow.find("span")

	var formTitle = modalPayment.find(".form-title")
	var formPayment = modalPayment.find(".form-payment")
	var inputPaymentId = formPayment.find("input[name=payment_id]")
	var selectClient = formPayment.find("select[name=client_id]")
	var inputValue = formPayment.find("input[name=value]")
	var emptyPayment = {
		id: 0,
		client_id: 0,
		value: 0
	}

	var controlModalService = function (confOverflow, display) {
		overflowMsg.removeClass()
		if (confOverflow) {
			if (confOverflow.text) {
				overflowMsg.text(confOverflow.text)
			}

			if (confOverflow.textClass) {
				overflowMsg.addClass("text-" + confOverflow.textClass)
			}

			overflow.show()
			if (confOverflow.hideAfter) {
				overflow.hide(3000)
			}
		}

		if (display) {
			modalPayment.modal(display)
		}
	}

	var loadMasks = function () {
		inputValue.mask("##0.00", {
			reverse: true,
			placeholder: "0.00"
		})
	}

	var validatePayment = function (payment) {
		conf = {
			text: "Validando pagamento...",
			textClass: "info"
		}
		controlModalService(conf)

		var errors = {}
        var client_id = payment.client_id
        var value = payment.value

        if (! client_id || client_id == "0") {
        	errors.client = "Cliente inválido"
        }

        if (! value || value != Number(value) || value <= 0) {
            errors.value = "Valor inválido"
        }

        return errors
    }

    var displayErrors = function (errors) {
		if (errors.client) {
			selectClient.parent().addClass("has-error")
		}

		if (errors.value) {
			inputValue.parent().addClass("has-error")
		}

    	conf = {
			text: "Pagamento inválido",
			textClass: "danger",
			hideAfter: true
		}
		controlModalService(conf)
    }

    var cleanErrors = function () {
    	formPayment.find("has-error").removeClass("has-error")
    }

    var fillPayment = function (payment) {
    	var id = payment.id
    	var client = payment.client_id
    	var value = Number(payment.value)

    	if (id) {
    		formTitle.text("Editando pagamento #" + id)
    		inputPaymentId.val(id)
    	} else {
    		formTitle.text("Novo pagamento")
    		inputPaymentId.val(0)
    	}

    	if (client || client === 0) {
			selectClient.find("option").attr("selected", false)
			selectClient.find("option[value=" + client + "]")
				.attr("selected","selected")
		}

		if (value) {
			inputValue.val(Number(value).toFixed(2))
		}
		loadMasks()
    }

   	var clearPayment = function () {
   		fillPayment(emptyPayment)
   	}

   	var loadPayment = function (payment_id) {
        $.ajax({
            headers: {
                "X-CSRF-Token": window.Laravel.csrfToken
            },
            url: pageUrl + "/" + payment_id,
            type: "GET",
            dataType: "json",
            beforeSend: function () {
                conf = {
					text: "Carregando pagamento #"+ payment_id +"...",
					textClass: "info"
				}
				controlModalService(conf, SHOW_MODAL)
            },
            success: function (data) {
            	conf = {
					text: "Erro ao carregar serviço!",
					textClass: "danger",
					hideAfter: true
				}
                if (data.status) {
                	fillPayment(data.record)
                	conf.text = "Pagamento carregado com sucesso!"
                	conf.textClass = "success"
                }
                controlModalService(conf)
            },
            error: function (data) {
                conf = {
					text: "Erro ao recuperar dados do servidor",
					textClass: "danger"
				}
				controlModalService(conf)
            }
        })
    }

    var getFormData = function () {
        return {
            client_id: selectClient.val(),
            value: inputValue.val()
        }
    }

    var sentForm = function (data) {
    	var id = inputPaymentId.val()
		var method = "POST"
		var url = pageUrl

        if (id && id !== "0") {
            method = "PUT"
            url += "/" + id
        }

        $.ajax({
            headers: {
                "X-CSRF-Token": window.Laravel.csrfToken
            },
            url: url,
            type: method,
            data: data,
            dataType: "json",
            beforeSend: function () {
				conf = {
					text: "Salvando...",
					textClass: "info"
				}
				controlModalService(conf, SHOW_MODAL)
			},
			success: function (data) {
                conf = {
					text: "Erro ao salvar registro!",
					textClass: "danger"
				}
				if (data.status) {
					conf.text = "Pagamento salvo com sucesso!"
					conf.textClass = "success"
				}
				controlModalService(conf)
            },
			error: function () {
				conf = {
					text: "Erro na requisição ao servidor!",
					textClass: "danger"
				}
				controlModalService(conf)
			},
			complete: function () {
				controlModalService({}, HIDE_MODAL)
			}
        })
    }

	var handleEvents = function () {
		var domDocument = $(document)
		
		domDocument.on("click", "#btn-add-payment", function (e) {
			var conf = {
				text: "Carregando...",
				textClass: "info",
				hideAfter: true
			}
			controlModalService(conf, SHOW_MODAL)
		})

        domDocument.on('click', '.edit-payment', function (e) {
            e.preventDefault()

            var payment_id = $(this).data('id');

            if (payment_id) {
                loadPayment(payment_id)
            } else {
                alert('Erro ao recuperar ID do pagamento.');
            }
        })

		formPayment.on("submit", function (e) {
			e.preventDefault()
			cleanErrors()
			let data = getFormData()
			let errors = validatePayment(data)
			if (Object.keys(errors).length === 0 && errors.constructor === Object) {
				sentForm(data)
			} else {
				displayErrors(errors)
			}
		})

		modalPayment.on("shown.bs.modal", function (e) {
			loadMasks()
		})

		modalPayment.on("hidden.bs.modal", function (e) {
			clearPayment()
		})
	}

	return {
		init: function () {
			handleEvents()
		}
	}
}()

$(document).ready(function () {
	PaymentFunctions.init()
})