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
    var html = '';
    for (let i = 0; i < product.length; i++) {
        html += `<div class="product-item ${product[i].type}">
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
            html += `<div class="product-item ${product[i].type}">
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


$(document).ready(() => {
    var html = '';
    for (let i = 0; i < product.length; i++) {
        html += `<img id="img" class="desc-img" src="${product[i].img}" alt="">
                        <div class="desc-detail">
                            <p id="productname" style="font-size: 1.5vw">Product Name</p>
                            <p id="price" style="font-size: 1.2vw">500 THB</p>
                            <p id="descript">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, suscipit.</p>
                            <br>
                            <div class="btn-control">
                                <a href="user_home.php" class="btn btn-danger">Cancel</a>
                                <button class="btn btn-success btn-add-to-card">Add to Cart</button>
                            </div>
                        </div>`;
    }
    $("#Desc").html(html);
    
})