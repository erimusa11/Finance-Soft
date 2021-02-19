$(document).ready(function () {
  //init product unit
  var productUnitBuy = 1;

  //click on product
  $(".productList").on("click", function () {
    //hide no data tr
    $(".no-data-table").remove();
    //get div data
    var productId = $(this).children().find(".productId").val();
    var productName = $(this).children().find(".productName").text().trim();
    var productUnit = +$(this).children().find(".productUnit").text();
    var productPrice = +$(this).children().find(".productPrice").text();
    var totalPriceInvoice = +$(".totalPriceInvoice").val();

    var newProductUnit = productUnit - 1;

    var totalPrice = productPrice * productUnitBuy;

    var tableRow = `<tr id="nrRow${productId}">
                                                        <td>
                                                            <input class="form-control text-center invoiceProductId"
                                                                type="text" value="${productId}" name="invoiceProductId[]"
                                                                hidden readonly>
                                                            <input class="form-control text-center totalProductUnit"
                                                                type="text" value="${productUnit}" name="totalProductUnit[]"
                                                                hidden readonly>
                                                            <div class="product-name">${productName}</div>
                                                        </td>
                                                        <td>
                                                                <input class="form-control productPrice costum-input" type="text"
                                                                    placeholder="" value="${productPrice}" name="productPrice[]" readonly>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend decrementUnit"><span
                                                                        class="input-group-text"><i
                                                                            class="fa fa-minus"></i></span></div>
                                                                <input class="form-control text-center productUnitBuy costum-input"
                                                                    type="number" min="0" oninput="validity.valid||(value='');" value="${productUnitBuy}"  name="productUnitBuy[]">
                                                                <div class="input-group-append incrementUnit"><span
                                                                        class="input-group-text"><i
                                                                            class="fa fa-plus"></i></span></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                                <input class="form-control totalPrice costum-input" type="text"
                                                                    placeholder="" value="${totalPrice}"  name="totalPrice[]"  readonly>
                                                        </td>
                                                        <td>
                                                            <div class="btn btn-danger removeRow"><i
                                                                    class="fa fa-trash"></i></div>
                                                        </td>

                                                    </tr>`;

    //count table rows
    var countTableRow = $("#productTable tr").length;

    //count table row with specific id
    var selectSpecificRow = `tr#nrRow${productId}`;
    var countSpecificRow = $(selectSpecificRow).length;

    var productUnitBuyValue = +$("#nrRow" + productId)
      .find(".productUnitBuy")
      .val();

    if ($(this).hasClass("disabled")) {
      var val = "noStock";
      notAllowedValue(val);
    } else {
      if (newProductUnit < 0) {
        var val = "greaterThanStock";
        notAllowedValue(val);
      } else {
        //if table doesn't have row
        if (countTableRow == 0) {
          $("#productTable").html(tableRow);
          $(this).children().find(".productUnit").html(newProductUnit);
        } else {
          //if the row is already added to table
          if (countSpecificRow >= 1) {
            totalPrice = (productPrice * (productUnitBuyValue + 1)).toFixed(2);
            $("#nrRow" + productId)
              .find(".productUnitBuy")
              .val(productUnitBuyValue + 1);
            $("#nrRow" + productId)
              .find(".totalPrice")
              .val(totalPrice);
            $(this).children().find(".productUnit").html(newProductUnit);
          } else {
            //if the row isn't in the table add new row
            $("#productTable tr:last").after(tableRow);
            $(this).children().find(".productUnit").html(newProductUnit);
          }
        }
        //calculate total invoice
        var totalPriceInvoice = calc_totalInvoice();
        $(".totalPriceInvoice").val(totalPriceInvoice);
      }
    }
  });

  //sweet alert
  function notAllowedValue(val) {
    if (val == "smallerThanZero") {
      swal("Gabim!", "Sasia nuk mund të jetë zero ose më e vogël se zero!", "error");
    }

    if (val == "greaterThanStock") {
      swal(
        "Gabim!",
        "Sasia për të blerë nuk mund të jetë më e madhe se gjendja!",
        "error"
      );
    }

    if (val == "noStock") {
      swal("Gabim!", "Nuk ka gjendje për këtë produkt!", "error");
    }
  }

  //function to increment or decrement invoice product unit
  function invoiceProductUnit(element, actionType) {
    var productId = +element.closest("tr").find(".invoiceProductId").val();
    var productUnitToBuy = +element.closest("tr").find(".productUnitBuy").val();
    var totalPriceInvoice = +$(".totalPriceInvoice").val();
    if (actionType == "inc") {
      productUnitToBuy += 1;
    } else if (actionType == "dec") {
      productUnitToBuy -= 1;
   
    }
    console.log(productUnitToBuy);
    if(productUnitToBuy <= 0){
      var alertVal = "smallerThanZero";
      notAllowedValue(alertVal);
    }else{
      ajaxCheck(productId, productUnitToBuy, element, totalPriceInvoice);
    }
  }

  //decrement product unit in invoice
  $("body").on("click", ".decrementUnit", function () {
    var element = $(this);
    var actionType = "dec";
    invoiceProductUnit(element, actionType);
  });

  //increment product unit in invoice
  $("body").on("click", ".incrementUnit", function () {
    var element = $(this);
    var actionType = "inc";
    invoiceProductUnit(element, actionType);
  });

  //change product unit in invoice with input
  $("body").on("blur", ".productUnitBuy", function () {
    var element = $(this);
    var actionType = "key up";
    if(element.val() <= 0){
      var alertVal = "smallerThanZero";
      notAllowedValue(alertVal);
      element.val(1);
    }else{
      invoiceProductUnit(element, actionType);
    }
  });

  //delete invoice row
  $("body").on("click", ".removeRow", function () {
    var invoiceProduct = +$(this).closest("tr").find(".productUnitBuy").val();

    var rowId = +$(this).closest("tr").find(".invoiceProductId").val();
    var productUnitTotal = +$(`.${rowId}`).find(".productUnit").text();

    var newProductUnitTotal = invoiceProduct + productUnitTotal;
    $(`.${rowId}`).find(".productUnit").html(newProductUnitTotal);
    $(this).closest("tr").remove();
    var totalPriceInvoice = calc_totalInvoice();
    $(".totalPriceInvoice").val(totalPriceInvoice);
  });

  //fun calculate total invoice
  function calc_totalInvoice() {
    var sum = 0;
    $(".totalPrice").each(function () {
      sum += parseFloat($(this).val());
    });
    return sum;
  }

  //fun block ui
  function blockUiShow() {
    $(".invoiceBlocUi").block({
      message: `<div class="loader-box">
                        <div class="loader-7"></div>
                      </div>`,
      overlayCSS: {
        backgroundColor: "#000",
        opacity: 0.6,
        cursor: "wait",
      },
      css: {
        border: 0,
        color: "#fff",
        padding: 0,
        backgroundColor: "transparent",
      },
    });
  }

  //fun remove block ui
  function blockUiHide() {
    $(".invoiceBlocUi").unblock();
  }

  //check if the product is in stock
  function ajaxCheck(productId, productUnitToBuy, element) {
    $.ajax({
      method: "POST",
      url: "../ajaxCheckUnitStock.php",
      data: {
        productId: productId,
        productUnitToBuy: productUnitToBuy,
      },
      beforeSend: function () {
        blockUiShow();
      },
      success: function (data) {
        if (data == "outOfStock") {
          notAllowedValue("greaterThanStock");
          var resetProductUnit = 1;
          var productPrice = element.closest("tr").find(".totalPrice").val();
          var totalPrice = resetProductUnit * productPrice;
          element.closest("tr").find(".productUnitBuy").val(resetProductUnit);
          element.closest("tr").find(".totalPrice").val(totalPrice.toFixed(2));
          var totalPriceInvoice = calc_totalInvoice();
          $(".totalPriceInvoice").val(totalPriceInvoice);
        } else {
          var parseData = JSON.parse(data);
          var unitToBuy = parseData[0].unitToBuy;
          var unitStock = parseData[0].unitStock;
          var newUnitStock = parseData[0].newUnitStock;
          var totalPrice = parseData[0].totalPrice;

          element.closest("tr").find(".productUnitBuy").val(unitToBuy);
          element.closest("tr").find(".totalPrice").val(totalPrice);
          var totalPriceInvoice = calc_totalInvoice();
          $(".totalPriceInvoice").val(totalPriceInvoice);
          $(`.${productId}`).find(".productUnit").html(newUnitStock);
        }
      },
      complete: function () {
        blockUiHide();
      },
    });
  }

  //search on product list
  $("#search").keyup(function () {
    // Retrieve the input field text and reset the count to zero
    var filter = $(this).val(),
      count = 0;
    // Loop through the comment list
    $("#productList div").each(function () {
      // If the list item does not contain the text phrase fade it out
      if ($(this).text().search(new RegExp(filter, "i")) < 0) {
        $(this).hide(); // hide if not found
        // Show the list item if the phrase matches and increase the count by 1
      } else {
        $(this).show(); // show if found
        count++;
      }
    });
  });
});
