Number.prototype.formatPrice = function (m, c, d, t) {
    var n = this,
    m = m == undefined ? "R$ " : m,
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "," : d, 
    t = t == undefined ? "." : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
    
    return s + m + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

Number.prototype.formatWeight = function () {
    var n = this

    return n.toFixed(3) + " Kg"
}

Date.prototype.addHours = function (hours) {
    var date = new Date(this.valueOf())
    date.setHours(date.getHours() + hours)
    return date
}

Date.prototype.fixUTC = function () {
    return this.addHours(3)
}

function getDayMonth (date) {
    let month = date.getMonth() + 1

    if (month.toString().length === 1) {
        month = '0' + month
    }
    let day = date.getDate()
    if (day.toString().length === 1) {
        day = '0' + day
    }

    return [day, month]
}

Date.prototype.getInputDate = function () {
    let dayMonth = getDayMonth(this)
    
    let day = dayMonth[0];
    let month = dayMonth[1];

    return this.getFullYear() + '-' + month + '-' + day
}

String.prototype.setInputDate = function () {
    let dateHours = this.split(" ")
    return dateHours[0]
}

String.prototype.formatDate = function () {
    let dateHours = this.split(" ")
    let date = dateHours[0].split("-")
    let hours = dateHours[1].split(":")
    
    return date[2] + "/" + date[1] + "/" + date[0]
}

function showLoading () {
    $('.loading_overlay').show()
}

function hideLoading () {
    $('.loading_overlay').hide()
}

/*
Array.prototype.getServiceValue = function () {
    let total = 0;

    $.each(this, function (index, item) {
        total += Number(item.price) * Number(item.quantity)
    })

    return total.formatPrice()
}*/

/*function message (object, addClass, text) {
    object.removeClass("alert-info alert-danger alert-success alert-warning")
    object.addClass(addClass)
    object.text(text)
}

function paginate (currentPage, lastPage) {
    var paginate = $("<ul></ul>").addClass("pagination")
    
    for (var i = 1; i <= lastPage; i++) {
        var page = $("<li></li>")
            .html("<a href=# data-page="+ i +">"+ i +"</a>")

        if (currentPage === i) {
            page.addClass("active")
        }

        paginate.append(page)
    }

    return paginate
}*/