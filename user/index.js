var product = [{
    id: 1,
    img: 'https://images.unsplash.com/photo-1616967520023-5d658b3cd0c6?q=80&w=1035&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    name: 'Shoe',
    price: 700,
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil soluta voluptas obcaecati molestiae natus deserunt possimus sit nam optio delectus.',
    type: 'shoe'
}, {
    id: 2,
    img: 'https://images.unsplash.com/photo-1531390979850-32568e0159ce?q=80&w=1031&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    name: 'Water',
    price: 1200,
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil soluta voluptas obcaecati molestiae natus deserunt possimus sit nam optio delectus.',
    type: 'water'
}, {
    id: 3,
    img: 'https://images.unsplash.com/photo-1608587070000-86389cc7291e?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    name: 'Food',
    price: 900,
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil soluta voluptas obcaecati molestiae natus deserunt possimus sit nam optio delectus.',
    type: 'food'
}];

$(document).ready(() => {
    var html = '';
    for (let i = 0; i < product.length; i++) {
        html += `<a onclick="searchproduct('${product[i].type}')" class="sidebar-menu-filter" style="cursor: pointer;">${product[i].type}</a>`;
    }
    $("#menufilterlist").html(html);
})

$(document).ready(() => {

    $.ajax({
        method: 'get',
        url: 'getallproduct.php',
        success: function(response) {
            console.log(response)
        }, error: function(err) {
            console.log(err)
        }
    })

    var html = '';
    for (let i = 0; i < product.length; i++) {
        html += `<div onclick="openProductDetail(${i})" class="product-item ${product[i].type}">
                <a href="user_product.php">
                <img class="product-img" src="${product[i].img}" alt="">
                <p style="font-size: 1.2vw;">${product[i].name}</p>
                <p style="font-size: 0.9vw;">${numberWithCommas(product[i].price)} THB</p></a>
            </div>`;
    }
    $("#productlist").html(html);
})

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

function searchsome(elem) {
    var value = $('#'+elem.id).val()
    console.log(value)

    var html = '';
    for (let i = 0; i < product.length; i++) {
        if(product[i].name.includes(value)) {
            html += `<div onclick="openProductDetail(${i})" class="product-item ${product[i].type}">
                    <a href="user_product.php">
                    <img class="product-img" src="${product[i].img}" alt="">
                    <p style="font-size: 1.2vw;">${product[i].name}</p>
                    <p style="font-size: 0.9vw;">${numberWithCommas(product[i].price)}</p></a>
                </div>`;
        }
    }
    if(html == '') {
        $("#productlist").html(`<p>ไม่มีสินค้า</p>`);
    } else {
        $("#productlist").html(html);
    }
}

function searchproduct(param) {
    console.log(param) 
    $(".product-item").css('display', 'none')
    if(param == 'all') {
        $(".product-item").css('display', 'block')
    } else {
        $("." + param).css('display', 'block')
    }
}


var productindex = 0;
function openProductDetail(i) {
    productindex = i;
    console.log(productindex)
    if (product[i]) {
    $("#img").attr('src', product[i].img);
    $("#productname").text(product[i].name);
    $("#price").text(product[i].price);
    $("#descript").text(product[i].descript);
    } else {
        console.error('Product not found');
    }
}


var cart = [];
function addtocart() {
    var pass = true;
    for (let i = 0; i < cart.length; i++) {
        if(productindex == cart[i].index) {
            console.log('found same product')
            cart[i].count++;
            pass = false;
        }
    }

    if(pass) {
        var obj = {
            index: productindex,
            id: product[productindex].id,
            name: product[productindex].name,
            price: product[productindex].price,
            img: product[productindex].img,
            count: 1
        };
        //console.log(obj)
        cart.push(obj)
    }
    console.log(cart)

    Swal.fire({
        icon: 'success',
        title: 'Add ' + product[productindex].name + ' to cart'
    })
}

function openCart() {
    $('#Cart').css('display', 'flex')
    rendercart();
}

function rendercart() {
    if(cart.length > 0) {
        var html = '';
        for (let i = 0; i < array.length; i++) {
            html += `<div class="cartlist-item">
                            <div class="cartlist-left">
                                <img src="${cart[i].img}" alt="">
                                <div class="cartlist-detail">
                                    <p style="font-size: 1.5vw">${cart[i].name}</p>
                                    <p style="font-size: 1.2vw">${ numberWithCommas(cart[i].price) * cart[i].count} THB</p>
                                </div>
                            </div>
                            <div class="cartlist-right">
                                <p onclick="deinitems('-', ${i})" class="btn-con" style="font-size: 1.5vw">-</p>
                                <p id="countitems${i}" class="btn-text" style="font-size: 1.5vw">${cart[i].count}</p>
                                <p onclick="deinitems('+', ${i})" class="btn-con" style="font-size: 1.5vw">+</p>
                            </div>
                        </div>`;
        }
        $("#mycart").html(html)
    } else {
        $("#mycart").html(`<p>ไม่มีสินค้าในตะกร้า</p>`)
    }
}

function deinitems(action, index) {
    if(action == '-') {
        if(cart[index].count > 0) {
            cart[index].count--;
            $("#countitems"+index).text(cart[index].count)

            if(cart[index].count <= 0) {
                Swal.fire ({
                icon: 'warning',
                title: 'Are you sure to delete',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((res) => {
                if(res.showConfirmed) {
                    cart.splice(index, 1)
                    console.log(cart)
                    rendercart();
                } else {
                    cart[index].count++;
                    $("#countitems"+index).text(cart[index].count)
                }
            })

            }
        }
    } else if(action == '+') {
        cart[index].count++;
        $("#countitems"+index).text(cart[index].count)
    }
}