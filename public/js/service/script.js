var ServiceModalFunctions = function () {

	const SHOW_MODAL = "show"
	const HIDE_MODAL = "hide"

	const LAVAR = "lavar"
	const PASSAR = "passar"
	const LAVAR_E_PASSAR = "ambos"
	
	var serviceTypes = []
	serviceTypes[LAVAR] = "LAVAR"
	serviceTypes[PASSAR] = "PASSAR"
	serviceTypes[LAVAR_E_PASSAR] = "AMBOS"

	var modalService = $("#modal-service")
	var modalTitle = modalService.find(".service-title")
	var formService = modalService.find(".form-service")
	var inputId = formService.find("input[name=id]") 
	var selectClient = formService.find("select[name=client_id]")
	var inputCreatedAt = formService.find("input[name=created_at]")
	var inputDeliveryAt = formService.find("input[name=delivery_at]")
	var itemsContainer = formService.find(".service-items") 
	var rowsItems
	var overflow = modalService.find(".modal-message-overflow")
	var overflowMsg = overflow.find("span")
	var serviceTotal = $(".service-total")

	var baseUrl = "/json/services"
	
	var loadMasks = function () {
		$(".trigger-price").mask("##0.00", {
			reverse: true,
			placeholder: "0.00"
		})
		$(".trigger-quantity").mask("#0.000", {
			reverse: true,
			placeholder: "00.000"
		})
	}

	function cleanErrors() {
		$(".has-error").removeClass("has-error")
	}	

	function getItemData (domElement) {
		let row = $(domElement)
		let serviceItem = {
			item_id: row.find("select[name='items[][item_id]']").val(),
			type: row.find("select[name='items[][type]']").val(),
			price: row.find("input[name='items[][price]']").val(),
			quantity: row.find("input[name='items[][quantity]']").val()
		}
		
		return serviceItem
	}

	function getItems () {
		return itemsContainer.find(".row")
	}

	function getFormData () {
		let data = {
			client_id: selectClient.val(),
			delivery_at: inputDeliveryAt.val(),
			items: []
		}

		rowsItems = getItems()

		data.items = rowsItems.map(function (index, domElement) {
			return getItemData(domElement)
		}).toArray()
		
		return data
	}

	function validateClient(id, errors) {
		if (id === undefined || id === "0") {
			errors.client_id = "Selecione um cliente!"
		}
	}

	function validateItems(items, errors) {
		if (items.length > 0) {
			errors.items = []
			$.each(items, function (index, item) {
				let itemErrors = {}
				// Validate item
				if (!item.item_id || item.item_id === "0") {
					itemErrors.item_id = "Selecione um item"
				}
				// Validate type
				if (! $.inArray(item.type, serviceTypes) === -1) {
					itemErrors.type = "Serviço inválido"
				}
				// Validate price
				if (!item.price || isNaN(item.price)) {
					itemErrors.price = "Preço inválido"
				}
				// Validate quantity
				if (!item.quantity || isNaN(item.quantity)) {
					itemErrors.quantity = "Quantidade inválida"
				}

				if (!(Object.keys(itemErrors).length === 0 && itemErrors.constructor === Object)) {
					errors.items[index] = itemErrors
				}
			})
		} else {
			errors.items = "Lista de item inválida"
		}

		if (errors.items.length === 0) {
			delete errors.items
		}
	}

	function validateDeliveryAt(date, errors) {
		let d = new Date(date).fixUTC()
		if ( Object.prototype.toString.call(d) === "[object Date]" ) {
			// it is a date
			if ( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
				errors.delivery_at = "Data inválida"
			}
		} else {
			errors.delivery_at = "Data inválida"
		}
	}

	function validate(data) {
		let errors = {}
		validateClient(data.client_id, errors)
		validateDeliveryAt(data.delivery_at, errors)
		validateItems(data.items, errors)
		return errors
	}

	function displayErrors(errors) {
		if (errors.hasOwnProperty("client_id")) {
			selectClient.parent().addClass("has-error")
		}

		if (errors.hasOwnProperty("delivery_at")) {
			inputDeliveryAt.parent().addClass("has-error")
		}

		if (errors.hasOwnProperty("items")) {
			$.each(errors.items, function (index, item) {
				let row = $(rowsItems.get(index))
				if (item.hasOwnProperty("item_id")) {
					row.find("select[name='items[][item_id]']").parent().addClass("has-error")
				}
				if (item.hasOwnProperty("type")) {
					row.find("select[name='items[][type]']").parent().addClass("has-error")
				}
				if (item.hasOwnProperty("price")) {
					row.find("input[name='items[][price]']").parent().addClass("has-error")
				}
				if (item.hasOwnProperty("quantity")) {
					row.find("input[name='items[][quantity]']").parent().addClass("has-error")
				}
			})
		}
	}

	function addServiceItem () {
		let temp = $("<div></div>").html($("<i></i>").addClass("fa fa-spinner fa-spin"))

		$.ajax({
			url: baseUrl + "/service-item",
			dataType: "json",
			beforeSend: function () {
				itemsContainer.append(temp)
			},
			success: function (data) {
				if (data.status === 200) {
					temp.addClass("row").html(data.responseJson)
					loadMasks()
				}
			}
		})
	}

	function calculateServiceItemTotal (row) {
		let price = Number(row.find(".trigger-price").val())
		let quantity = Number(row.find(".trigger-quantity").val())
		if (!isNaN(price) && !isNaN(quantity)) {
			return price*quantity
		}

		return 0	
	}

	function setServiceTotal () {
		let total = 0
		
		rowsItems = getItems()

		rowsItems.each(function () {
			let row = $(this)
			total += calculateServiceItemTotal(row)
		})

		serviceTotal.text(Number(total).formatPrice())
	}

	function setServiceItemTotal (row) {
		let total = calculateServiceItemTotal(row)
		row.find(".item-total").val(Number(total).formatPrice())

		setServiceTotal()
	}

	function loadItem (item, row) {
		if (item.values[0]) {
			itemValue = item.values[0]
			let laundryPrice = Number(itemValue.laundry_price).toFixed(2)
			let ironingPrice = Number(itemValue.ironing_price).toFixed(2) 
			let bothPrice = Number(itemValue.both_price).toFixed(2) 
			let service = row.find(".trigger-service")
			let price = row.find(".trigger-price")
			let quantity = row.find(".trigger-quantity")
			let select = -1

			if (laundryPrice !== "0.00") {
				let option = $("<option></option>")
					.val(serviceTypes[LAVAR])
					.text("Lavar")
					.attr("data-price", laundryPrice)
				service.append(option)
				select++
			}

			if (ironingPrice !== "0.00") {
				let option = $("<option></option>")
					.val(serviceTypes[PASSAR])
					.text("Passar")
					.attr("data-price", ironingPrice)
				service.append(option)
				select++
			}

			if (bothPrice !== "0.00") {
				let option = $("<option></option>")
					.val(serviceTypes[LAVAR_E_PASSAR])
					.text("Lavar e passar")
					.attr("data-price", bothPrice)
				service.append(option)
				select++
			}
	
			if (select > -1) {
				let child = $(service.children().get(select))
				child.prop("selected", true)
				price.val(child.data("price")).prop("disabled", false).change()
				service.prop("disabled", false)
				quantity.prop("disabled", false)
			}
		}

		return row
	}

	function changeItem (id, row) {
		$.ajax({
			url: "/json/items/" + id,
			dataType: "json",
			beforeSend: function () {
				row.find(".trigger-service").empty().prop("disabled", true)
				row.find(".trigger-price").empty().prop("disabled", true)
				row.find(".trigger-quantity").prop("disabled", true)
			},
			success: function (data) {
				if (data.status) {
					loadItem(data.record, row)
				}
			}
		})	
	}

	function changeDate (inputDate) {
		let msg = $(".days-left")
		let now = new Date()
		let today = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 0, 0, 0 ,0)
		let delivery = new Date(inputDate.val()).addHours(3)
		let days = parseInt((delivery - today) / 1000 / 60 / 60 / 24)
		if (days < 0) {
			//alert("Não é possível voltar no tempo para entregar a roupa!\n\nSelecione uma data a partir de hoje")
			msg.val("Atrasado "+ (days * -1) + " dias")
			//inputDate.val(today.getInputDate())
		} else if (days === 0) {
			msg.val("Hoje")
		} else if (days === 1) {
			msg.val("Amanhã")
		} else {
			msg.val(days + " dias")
		}
	}

	function controlModalService (confOverflow, display) {
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
				overflow.hide(1000)
			}
		}

		if (display) {
			modalService.modal(display)
		}
	}

	function serviceTrigger () {
		var trigger = $(".service-trigger")
		if (trigger) {
			trigger.change()
		}
	}

	function sentForm(data) {
		let id = inputId.val()
		let type = "POST"
		let url = baseUrl

		if (id && id !== "0") {
			url += "/" + id
			type = "PUT"
		}
		
		$.ajax({
			headers: {
				"X-CSRF-TOKEN": window.Laravel.csrfToken
			},
			url: url,
			type: type,
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
					conf.text = "Serviço salvo com sucesso!"
					conf.textClass = "success"
				}
				serviceTrigger()
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

	function loadRowService (row, serviceItem) {
		// Seta o item do serviço
		row.find(".trigger-item").val(serviceItem.item_id)
		// Carrega o serviço na linha (função do form.js)
		row = loadItem(serviceItem.item, row)
		let service = row.find(".trigger-service")
		let price = row.find(".trigger-price")
		let quantity = row.find(".trigger-quantity")
		// Seta o serviço
		service.val(serviceItem.type)
		// Seta o preço
		price.val(Number(serviceItem.price))
		// Seta a quantidade
		quantity.val(Number(serviceItem.quantity).toFixed(3))
		// Calcula o total
		setServiceItemTotal(row)
		return row
	}

	function fillItems (items) {
		let emptyRow = $("<div></div>").addClass("row"),
		urlServiceItem = "/json/services/service-item",
		temp = $("<div></div>")
						.addClass("box-load")
						.html(
							$("<i></i>").addClass("fa fa-spinner fa-spin")
						)
		count = items.length

		return $.ajax({
			url: urlServiceItem,
			dataType: "json",
			beforeSend: function () {
				itemsContainer.empty()
				itemsContainer.append(temp)
			},
			success: function (data) {
				if (data.status === 200) {
					emptyRow.append($(data.responseJson))
					
					if (count > 0) {
						$.each(items, function (index, item) {
							let row = loadRowService(emptyRow.clone(), item)
							itemsContainer.append(row)
							if (!--count) {
								setServiceTotal()
							}
						})
					} else {
						itemsContainer.append(emptyRow.clone())
						setServiceTotal()
					}
				}
			},
			complete: function () {
				temp.remove()
			}
		})		
	}

	var fillService = function (service) {
		let id = service.id
		let client = service.client_id
		let created_at = service.created_at
		let delivery_at = service.delivery_at
		let items = service.items
		
		if (id) {
			modalTitle.text("Editando serviço #" + id)
			inputId.val(id)
		} else {
			modalTitle.text("Novo serviço");
			inputId.val(0)
		}
		if (client || client === 0) {
			selectClient.find("option").attr("selected", false)
			selectClient.find("option[value=" + client + "]")
				.attr("selected","selected")
		}

		if (created_at) {
			inputCreatedAt.val(created_at.setInputDate())
		}

		if (delivery_at) {
			inputDeliveryAt.val(delivery_at.setInputDate()).change()
		}

		if (items) {
			return fillItems(items)
		}
	}

	var loadService = function (id) {
		if (id && id !== "0") {
			let urlService = "/json/services/" + id
			let conf = {}
			$.ajax({
				url: urlService,
				type: "GET",
				dataType: "json",
				beforeSend: function () {
					conf = {
						text: "Carregando item #"+ id +"...",
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
						fillService(data.record).done(function (data) {
							if (data.status === 200) {
								conf.text = "Serviço carregado com sucesso!"
								conf.textClass = "success"
							}
							controlModalService(conf)
						})
					}
				},
				error: function (data) {
					conf = {
						text: "Erro ao recuperar dados do servidor",
						textClass: "danger"
					}
					controlModalService(conf, HIDE_MODAL)
				}
			})
		}
	}

	var cleanModal = function () {
		var emptyService = {
			id: 0,
			client_id: 0,
			created_at: new Date().getInputDate(),
			delivery_at: new Date().getInputDate(),
			items: []
		}

		fillService(emptyService)
	}

	var handleEvents = function () {
		var domDocument = $(document)
		
		domDocument.on("click", "#btn-add-service", function (e) {
			var conf = {
				text: "Carregando...",
				textClass: "info",
				hideAfter: true
			}
			controlModalService(conf, SHOW_MODAL)
		})

		domDocument.on("click", ".add-service-item", function (e) {
			e.preventDefault()

			addServiceItem()
		})

		domDocument.on("click", ".edit-service", function (e) {
			e.preventDefault()

			let id = $(this).data("id")
			loadService(id)
		})

		domDocument.on("click", ".service-remove", function (e) {
			e.preventDefault()

			$(this).closest(".row").remove()
		})

		domDocument.on("change", ".trigger-item", function (e) {
			e.preventDefault()

			let id = $(this).val()
			let row = $(this).closest(".row")
			
			changeItem(id, row)
		})

		domDocument.on("change", ".trigger-service", function (e) {
			e.preventDefault()
			
			let val = $(this).find("option:selected").data("price")
			
			val = ! isNaN(val) ? val : 0

			$(this).closest(".row").find(".trigger-price").val(Number(val).toFixed(2)).change()
		})

		domDocument.on("change", ".trigger-price,.trigger-quantity", function (e) {
			let row = $(this).closest(".row")
			setServiceItemTotal(row)
		})

		domDocument.on("change", ".trigger-date", function (e) {
			e.preventDefault()

			let date = $(this);

			changeDate(date);
		})

		formService.on("submit", function (e) {
			e.preventDefault()
			cleanErrors()
			let data = getFormData()
			let errors = validate(data)
			if (Object.keys(errors).length === 0 && errors.constructor === Object) {
				sentForm(data)
			} else {
				displayErrors(errors)
			}
		})

		modalService.on("shown.bs.modal", function (e) {
			loadMasks()
		})

		modalService.on("hidden.bs.modal", function (e) {
			cleanModal()
		})
	}

	return {
		init: function () {
			handleEvents()
		}
	}
}()

$(document).ready(function () {
	ServiceModalFunctions.init()
})