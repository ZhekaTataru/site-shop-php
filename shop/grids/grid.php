<?php
require_once "../functions/functions.php";
require($_SERVER['DOCUMENT_ROOT'] . '/blocks/header.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Orders Grid</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/css/ui.jqgrid.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script>
  <style>
    .content_grid{
      width: 800px;
      margin: 0 auto;
    }
    .container {
      margin: 0 auto;
      display: none;
      justify-content: center;
      align-items: center;
      margin-top: 80px;
    }

    .active {
      display: flex;
    }

    /* Кнопки переключения контейнеров */
    button {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
    }

    /* Гриды */
    .ui-jqgrid .ui-jqgrid-btable {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .ui-jqgrid .ui-jqgrid-htable th {
      background-color: #4CAF50;
      color: green;
      padding: 5px;
      border: 1px solid #ddd;
    }
  </style>
</head>

<body>
  <div class="content">
    <div class="content_grid">
    <div style="margin: 0 auto;">
      <button id="ordersBtn">Orders</button>
      <button id="helpsBtn">Helps</button>
      <button id="commentsBtn">Comments</button>
      <button id="usersBtn">Users</button>
      <button id="productsBtn">Products</button>
    </div>
    <div id="ordersContainer" class="container active">
      <table id="ordersGrid"></table>
      <div id="ordersPager"></div>
    </div>
    <div id="helpsContainer" class="container">
      <table id="helpsGrid"></table>
      <div id="helpsPager"></div>
    </div>
    <div id="commentsContainer" class="container">
      <table id="commentsGrid"></table>
      <div id="commentsPager"></div>
    </div>
    <div id="usersContainer" class="container">
      <table id="usersGrid"></table>
      <div id="usersPager"></div>
    </div>
    <div id="productsContainer" class="container">
      <table id="productsGrid"></table>
      <div id="productsPager"></div>
    </div>
  </div>
  </div>
  
  <? require($_SERVER['DOCUMENT_ROOT'] . '/blocks/foother.php'); ?>
  <script>
    $(document).ready(function() {
      function showContainer(containerId) {
        $(".container").removeClass("active");
        $("#" + containerId).addClass("active");
      }

      $("#ordersBtn").click(function() {
        showContainer("ordersContainer");
      });

      $("#helpsBtn").click(function() {
        showContainer("helpsContainer");
      });

      $("#commentsBtn").click(function() {
        showContainer("commentsContainer");
      });

      $("#usersBtn").click(function() {
        showContainer("usersContainer");
      });

      $("#productsBtn").click(function() {
        showContainer("productsContainer");
      });

      // Orders Grid
      $("#ordersGrid").jqGrid({
        url: "getordersdata.php",
        datatype: "json",
        colModel: [{
            label: "User ID",
            name: "user_id",
            width: 80
          },
          {
            label: "ID",
            name: "id",
            width: 80,
            sortable: true
          },
          {
            label: "Products",
            name: "products",
            width: 150
          },
          {
            label: "Total Price",
            name: "total_price",
            width: 150
          },
          {
            label: "Name",
            name: "name",
            width: 150
          },
          {
            label: "Email",
            name: "email",
            width: 150
          },
          {
            label: "Phone",
            name: "phone",
            width: 150
          },
          {
            label: "City",
            name: "city",
            width: 150
          },
          {
            label: "Post Index",
            name: "post_index",
            width: 150
          },
          {
            label: "Created At",
            name: "created_at",
            width: 150
          },
          {
            label: "Address",
            name: "address",
            width: 150
          }

        ],
        viewrecords: true,
        height: 500,
        rowNum: 10,
        pager: "#ordersPager",
        pagerpos: 'left',
        recordpos: 'right',
        rowList: [10, 20, 30],
        toppager: true,
        viewrecords: true,

      });


      // Helps Grid
      $("#helpsGrid").jqGrid({
        url: "gethelpsdata.php",
        datatype: "json",
        colModel: [{
            label: "ID",
            name: "id",
            width: 80,
            sortable: true
          },
          {
            label: "Name",
            name: "name",
            width: 150
          },
          {
            label: "Username",
            name: "username",
            width: 150
          },
          {
            label: "Phone",
            name: "phone",
            width: 150
          },
          {
            label: "Created At",
            name: "created_at",
            width: 150
          }
        ],
        viewrecords: true,
        height: 500,
        rowNum: 10,
        pager: "#helpsPager",
        pagerpos: 'left',
        recordpos: 'right',
        rowList: [10, 20, 30],
        toppager: true,
        viewrecords: true,

      });

      // Comments Grid
      $("#commentsGrid").jqGrid({
        url: "getcommentsdata.php",
        datatype: "json",
        colModel: [{
            label: "ID",
            name: "id",
            width: 80,
            sortable: true
          },
          {
            label: "Product ID",
            name: "product_id",
            width: 80
          },
          {
            label: "User ID",
            name: "user_id",
            width: 80
          },
          {
            label: "Comment",
            name: "comment",
            width: 150
          },
          {
            label: "Created At",
            name: "created_at",
            width: 150
          }
        ],
        viewrecords: true,
        height: 500,
        rowNum: 10,
        pager: "#commentsPager",
        pagerpos: 'left',
        recordpos: 'right',
        rowList: [10, 20, 30],
        toppager: true,
        viewrecords: true,

      });

      // Users Grid
      $("#usersGrid").jqGrid({
        url: "getusersdata.php",
        datatype: "json",
        colModel: [{
            label: "ID",
            name: "id",
            width: 80,
            sortable: true
          },
          {
            label: "Full Name",
            name: "full_name",
            width: 150
          },
          {
            label: "Login",
            name: "login",
            width: 150
          },
          {
            label: "Email",
            name: "email",
            width: 150
          },
          {
            label: "Password",
            name: "password",
            width: 150
          },
          {
            label: "Admin",
            name: "is_admin",
            width: 80
          }
        ],
        viewrecords: true,
        height: 500,
        rowNum: 10,
        pager: "#usersPager",
        pagerpos: 'left',
        recordpos: 'right',
        rowList: [10, 20, 30],
        toppager: true,
        viewrecords: true,

      });

      // products Grid
      $("#productsGrid").jqGrid({
        url: "getproductsdata.php",
        datatype: "json",
        colModel: [{
            label: "ID",
            name: "id",
            width: 80,
            sortable: true
          },
          {
            label: "Image",
            name: "img",
            width: 150
          },
          {
            label: "Title",
            name: "title",
            width: 150
          },
          {
            label: "Category",
            name: "category",
            width: 150
          },
          {
            label: "Text",
            name: "text_tovar",
            width: 150
          },
          {
            label: "Price",
            name: "price",
            width: 150
          },
          {
            label: "Recommended",
            name: "recommended",
            width: 150
          }
        ],
        viewrecords: true,
        height: 500,
        rowNum: 10,
        pager: "#productsPager",
        pagerpos: 'left',
        recordpos: 'right',
        rowList: [10, 20, 30],
        toppager: true,
        viewrecords: true,

      });
    });
  </script>
</body>

</html>