var ServiceFunctions = function () {
    const COL_CLIENT = 0
    const COL_DELIVERY_AT = 1
    const COL_DELIVERED_AT = 2
    const COL_VALUE = 3
    const COL_ACTIONS = 4

    const STATUS_NOT_DELIVERED = 3

    var pageUrl = "/json/services"
    var notificationUrl = "/json/notifications"
    var servicesTable = $("#services-table")
    var notificationsBox = $(".notification-container")
    var notificationsLoading = $(".notification-loading")
    var notificationEmpty = $("<div></div>")
                                .addClass("notification")
                                .html(
                                    $("<span></span>")
                                )
    var dataTable
    
    var getFilters = function () {
        var d = new Date()
        
        return {
            status: STATUS_NOT_DELIVERED,
            deliveryAtEnd: d.getInputDate()
        }
    }

    /**************************************
    * FUNÇÕES DA TABELA
    **************************************/
    var initTable = function (options) {
        dataTable = servicesTable.DataTable( {
            language: options.language,
            ajax: {
                url: pageUrl,
                data: function ( d ) {
                    d = getFilters()
                    return d
                },
                dataSrc: 'records'
            },
            columns: [
                { 
                    data: 'client',
                    render: function (data, type, row) {
                        return data.code + ' - ' + data.name
                    }
                },
                { 
                    data: 'delivery_at',
                    render: function (data, type, row) {
                        return data.formatDate()
                    }
                },
                { 
                    data: 'delivered_at',
                    render: function (data, type, row) {
                        return data ? data.formatDate() : 'Não entregue'
                    }
                },
                { 
                    data: 'value',
                    render: function (data, type, row) {
                        return Number(data).formatPrice()
                    }
                },
                { 
                    data: null,
                    render: function (data, type, row) {

                        var columnActions = $("<div></div>")

                        if (! row.is_ready) {
                            var readyAction = $("<a></a>")
                                                .attr("href", "#")
                                                .attr("data-action", "ready")
                                                .attr("data-id", row.id)
                                                .attr("title", "Serviço pronto")
                                                .addClass("ready-record")
                                                .html(
                                                    $("<i></i>")
                                                        .addClass("fa fa-check")
                                                )
                            columnActions.append(readyAction)                            
                        }

                        if (! row.delivered_at) {
                            var deliveryAction = $("<a></a>")
                                                .attr("href", "#")
                                                .attr("data-action", "delivery")
                                                .attr("data-id", row.id)
                                                .attr("title", "Serviço entregue")
                                                .addClass("delivery-record")
                                                .html(
                                                    $("<i></i>")
                                                        .addClass("fa fa-thumbs-up")
                                                )
                            columnActions.append(deliveryAction)
                        }


                        var editAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "edit")
                                            .attr("data-id", row.id)
                                            .addClass("edit-service")
                                            .html(
                                                $("<i></i>")
                                                    .addClass("fa fa-pencil")
                                            )
                        columnActions.append(editAction)
                        
                        var deleteAction = $("<a></a>")
                                            .attr("href", "#")
                                            .attr("data-action", "remove")
                                            .attr("data-id", row.id)
                                            .addClass("remove-record")
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
                [COL_DELIVERY_AT, "desc"],
                [COL_CLIENT, "asc"]
            ],
            columnDefs: [
                {
                    type: "extract-date",
                    targets: [ COL_DELIVERY_AT ]
                },
                { 
                    className: "col-actions",
                    targets: [ COL_ACTIONS ]
                }
            ],
            fnDrawCallback: function(data) {
                hideLoading()  
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                var rowClass
                if (aData.delivered_at) {
                    rowClass = "service-delivered"
                } else if (aData.is_ready) {
                    rowClass = "service-ready"
                } else if ((new Date(aData.delivery_at)).addHours(24) < new Date()) {
                    rowClass = "service-late"
                }

                $(nRow).addClass( rowClass );
                return nRow
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( COL_VALUE )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Total over this page
                pageTotal = api
                    .column( COL_VALUE, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column( COL_VALUE ).footer() ).html(
                    Number(pageTotal).formatPrice() + ' (' + Number(total).formatPrice() +' total)'
                );
            }
        } )
    }

    var loadNotification = function (n) {
        var notification = notificationEmpty.clone()
        if (n.class) {
            notification.addClass(n.class)
        }

        notification.find("span").text(n.text)

        return notification
    }

    var getNotifications = function () {
        $.ajax({
            url: notificationUrl,
            beforeSend: function () {
                notificationsBox.empty()
                notificationsLoading.removeClass("hidden");
            },
            success: function (data) {
                var notification
                if (data.status) {
                    $.each(data.records, function (index, record) {
                        notification = loadNotification(record)
                        notificationsBox.append(notification)
                    })
                } else {
                    notification = loadNotification({
                        class: "danger",
                        text: "Erro ao carregar notificações"
                    })
                    notificationsBox.append(notification)
                }
            },
            error: function () {
                var notification = loadNotification({
                    class: "danger",
                    text: "Erro na requisição ao servidor"
                })
                notificationsBox.append(notification)
            },
            complete: function () {
                notificationsLoading.addClass("hidden")
            }            
        })
    }

    /**************************************
    * BOTÕES
    **************************************/
    var handleButtons = function () {

        $(document).on("change", ".service-trigger", function () {
            dataTable.ajax.reload(null, false)
        })
        
        $(document).on("click", ".ready-record,.delivery-record,.remove-record", function (e) {
            e.preventDefault()
            showLoading()

            var record = $(this)
            var id = record.data("id")
            var url = pageUrl + "/" + id
            var confirmMsg = ""
            var errorMsg = "Erro ao atualizar o serviço!\n\nAtualizando registros."
            var successMsg = "Registro atualizado com sucesso!\n\nAtualizando registros."

            if (record.hasClass("ready-record")) {
                confirmMsg = "Serviço pronto?"
                type = "PATCH"
                url += "/ready"
            } else if (record.hasClass("delivery-record")) {
                confirmMsg = "Entregar o serviço?"
                type = "PATCH"
                url += "/delivery"
            } else if (record.hasClass("remove-record")) {
                confirmMsg = "Deseja excluir esse serviço?"
                type = "DELETE"
                successMsg = "Registro removido com sucesso!\n\nAtualizando registros."
                errorMsg = "Erro ao remover o serviço!\n\nAtualizando registros."
            }

            if (confirmMsg !== "" && confirm(confirmMsg)) {
                $.ajax({
                    headers: {
                        "X-CSRF-Token": $("input[name=_token]").val()
                    },
                    url: url,
                    type: type,
                    dataType: "json",
                    success: function (data) {
                        if (data.status) {
                            alert(successMsg)
                        } else {
                            alert(errorMsg)
                        }
                    },
                    error: function (data) {
                        alert("Erro na solicitaço ao servidor!")
                    },
                    complete: function () {
                        dataTable.ajax.reload(null, false)
                        getNotifications()
                    }
                })
            }
        })
    }

    return {
        init: function () {
            showLoading()
            //getRecords()    
            handleButtons()
            getNotifications()
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
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "extract-date-pre": function(value) {
            var date = value.split('/');
            return Date.parse(date[1] + '/' + date[0] + '/' + date[2])
        },
        "extract-date-asc": function(a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "extract-date-desc": function(a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    })

    ServiceFunctions.init()
})