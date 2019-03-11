<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
          <tr>
              <th colspan="2" scope="colgroup"> PARTICULARS</th>
              <th colspan="3" scope="colgroup">OPENING STOCK</th>
              <th colspan="3" scope="colgroup" >PURCHASE</th>
              <th colspan="3" scope="colgroup">SALES</th>
              <th colspan="3" scope="colgroup">CLOSING STOCK</th>
              <th colspan="3" scope="colgroup">Net Inventory</th>
          </tr>
          <tr>
              <th>Date</th>
              <th>Product Name</th>

              <th>QTY</th>
              <th>Price</th>
              <th>Amount</th>

              <th>QTY</th>
              <th>Price</th>
              <th>Amount</th>

              <th>QTY</th>
              <th>Price</th>
              <th>Amount</th>

              <th>QTY</th>
              <th>Price</th>
              <th>Amount</th>

              <th>Net Inventory</th>
          </tr>
        </thead>
        <tbody>
          <?php

              $prevdate = null;
              $closingQty = array();
              $closingAmountt = 0;
              $openingStock = array();
              if (!empty($records)) {
              $netInventory   = 0;
              $hasInventory = 0;
              //echo "<pre>"; print_r($records); echo "</pre>"; die;
               foreach ($records as $key => $value) {
                 $productRef = array();
                 $productQuantity = 0;
                foreach ($value as $keyyy => $items) {
                  $productRef[] .= $items->productRef;

                  if(isset($closingQty[$items->productRef])){
                    if($items->inventoryType==2){
                      $quantity = $closingQty[$items->productRef]['quantity'] - $items->quantity;
                    }else{
                    $amount = $closingQty[$items->productRef]['amount'] + $items->amount;
                    $quantity = $closingQty[$items->productRef]['quantity'] + $items->quantity;
                  }
                  }else{
                    $amount = $items->amount;
                    $quantity = $items->quantity;
                }

                $closingQty[$items->productRef] = array(
                  'quantity' => $quantity,
                  'amount' => $amount,
                );
                $closeStockQty = $closingQty[$items->productRef]['quantity'];

                if($keyyy == 0){
                  //echo "<pre>";print_r($openingStock);echo "</pre>";

                  if(isset($openingStock[$items->productRef]))
                  {
                    ?>
                    <tr id="inventory_<?php echo $items->transactionRef;?>">
                         <td><?php
                               $date = changeDateFormat($key,'d M Y');
                               if($date == $prevdate){
                                  $netInventory += $openingStock[$items->productRef]['closingAmount'];
                               }
                               else{
                                 echo $date; $netInventory = $openingStock[$items->productRef]['closingAmount'];
                               }
                             ?>
                         </td>
                         <?php
                           $count = array_count_values($productRef);
                           if($count[$items->productRef] == 1){ // for opening stock
                         ?>
                           <td><?php echo ucfirst($items->productName); ?></td>
                           <td><?php echo numberFormat($openingStock[$items->productRef]['openingStock']); ?></td>
                           <td><?php echo  numberFormat($openingStock[$items->productRef]['closingPrice']); ?></td>
                           <td><?php echo numberFormat($openingStock[$items->productRef]['closingAmount']); ?></td>
                           <td colspan="6"></td>
                         <?php } ?>
                         <td><?php echo numberFormat($openingStock[$items->productRef]['openingStock']); ?></td>
                         <td><?php echo numberFormat($openingStock[$items->productRef]['closingPrice']) ?></td>
                         <td><?php echo numberFormat($openingStock[$items->productRef]['closingAmount']) ?></td>
                         <td></td>
                     </tr>
                  <?php } ?>
                    <tr id="inventory_<?php echo $items->transactionRef;?>">
                         <td><?php
                               $date = changeDateFormat($key,'d M Y');
                               if($date == $prevdate){
                                  $netInventory += $items->amount;
                               }
                               else{
                                 if(empty($openingStock[$items->productRef]))
                                  {
                                      echo $date;
                                  }
                                 $netInventory += $items->amount;
                               }
                             ?>
                         </td>
                         <?php
                          if(empty($openingStock[$items->productRef])){ // checking record exit
                           $count = array_count_values($productRef);
                           if($count[$items->productRef] == 1){ // for opening stock
                         ?>
                           <td><?php echo ucfirst($items->productName); ?></td>
                           <td><?php echo numberFormat($closeStockQty); ?></td>
                           <td><?php echo $items->price; ?></td>
                           <td><?php echo $closingQty[$items->productRef]['amount']; ?></td>
                           <td colspan="6"></td>
                         <?php } }
                           else { /**For Sale Purchase*/
                           if($items->inventoryType == 2) // for sale
                           {?>
                             <td><?php echo ucfirst($items->productName); ?></td>
                             <td colspan="6"></td>
                             <td><?php echo  numberFormat($items->quantity); ?></td>
                             <td><?php echo $items->price; ?></td>
                             <td><?php echo $items->amount; ?></td>
                           <?php }

                           else if($items->inventoryType == 1) // for purchase
                           { ?>
                             <td><?php echo ucfirst($items->productName); ?></td>
                             <td colspan="3"></td>
                             <td ><?php echo numberFormat($items->quantity); ?></td>
                             <td><?php echo $items->price; ?></td>
                             <td><?php echo $items->amount; ?></td>
                             <td></td>
                             <td></td>
                             <td></td>
                           <?php }  } ?>
                         <td><?php echo numberFormat($closeStockQty);  ?></td>
                         <td><?php $numForPrice = $items->price; echo numberFormat($numForPrice); ?></td>
                         <td><?php
                                $numForAmount = $items->amount; echo numberFormat($numForAmount);
                                $openingStock[$items->productRef] =
                                                array('openingStock' => $closeStockQty,
                                                      'closingAmount' =>  $items->amount,
                                                      'closingPrice' => $items->price,
                                                      'closingProductRef' => $items->productRef,
                                                      'productName' => $items->productName,
                                                );
                         ?></td>
                         <td></td>
                     </tr>
                 <?php
               } else {
                 if(isset($openingStock[$items->productRef]))
                 {
                 ?>
                 <tr id="inventory_<?php echo $items->transactionRef;?>">

                      <?php
                        $count = array_count_values($productRef);
                        if($count[$items->productRef] == 1){ // for opening stock
                      ?>
                      <td><?php
                            $date = changeDateFormat($key,'d M Y');
                            if($date == $prevdate){
                               $netInventory += $openingStock[$items->productRef]['closingAmount'];
                            }
                            else{
                              echo $date; $netInventory = $openingStock[$items->productRef]['closingAmount'];
                            }
                          ?>
                      </td>
                        <td><?php echo ucfirst($items->productName); ?></td>
                        <td><?php echo numberFormat($openingStock[$items->productRef]['openingStock']); ?></td>
                        <td><?php echo  numberFormat($openingStock[$items->productRef]['closingPrice']); ?></td>
                        <td><?php echo numberFormat($openingStock[$items->productRef]['closingAmount']); ?></td>
                        <td colspan="6"></td>
                        <td><?php echo numberFormat($openingStock[$items->productRef]['openingStock']); ?></td>
                        <td><?php echo numberFormat($openingStock[$items->productRef]['closingPrice']) ?></td>
                        <td><?php echo numberFormat($openingStock[$items->productRef]['closingAmount']) ?></td>
                        <td></td>
                      <?php } ?>

                  </tr>
               <?php } ?>

               <tr id="inventory_<?php echo $items->transactionRef;?>">
                    <td><?php
                          $date = changeDateFormat($key,'d M Y');
                          if($date == $prevdate){
                             $netInventory += $items->amount;
                          }
                          else{
                            if(empty($openingStock[$items->productRef]))
                             {
                                 echo $date;
                             }
                            $netInventory = $items->amount;
                          }
                        ?>
                    </td>
                    <?php
                     if(empty($openingStock[$items->productRef])){ // checking record exit
                      $count = array_count_values($productRef);
                      if($count[$items->productRef] == 1){ // for opening stock
                    ?>
                      <td><?php echo ucfirst($items->productName); ?></td>
                      <td><?php echo numberFormat($closeStockQty); ?></td>
                      <td><?php echo $items->price; ?></td>
                      <td><?php echo $closingQty[$items->productRef]['amount']; ?></td>
                      <td colspan="6"></td>
                    <?php } }
                      else { /**For Sale Purchase*/
                      if($items->inventoryType == 2) // for sale
                      {?>
                        <td><?php echo ucfirst($items->productName); ?></td>
                        <td colspan="6"></td>
                        <td><?php echo  numberFormat($items->quantity); ?></td>
                        <td><?php echo $items->price; ?></td>
                        <td><?php echo $items->amount; ?></td>
                      <?php }

                      else if($items->inventoryType == 1) // for purchase
                      { ?>
                        <td><?php echo ucfirst($items->productName); ?></td>
                        <td colspan="3"></td>
                        <td ><?php echo numberFormat($items->quantity); ?></td>
                        <td><?php echo $items->price; ?></td>
                        <td><?php echo $items->amount; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      <?php }  } ?>
                    <td><?php echo numberFormat($closeStockQty);  ?></td>
                    <td><?php $numForPrice = $items->price; echo numberFormat($numForPrice); ?></td>
                    <td><?php
                           $numForAmount = $items->amount; echo numberFormat($numForAmount);
                           $openingStock[$items->productRef] = array('openingStock' => $closeStockQty,
                                                                     'closingAmount' =>  $items->amount,
                                                                     'closingPrice' => $items->price,
                                                                     'closingProductRef' => $items->productRef,
                                                                     'productName' => $items->productName,
                                                               );
                    ?></td>
                    <td></td>
                </tr>
               <?php }
                 /// varibale to check previousDate
                 $prevdate =  changeDateFormat($items->date,'d M Y');

                }?>
                <tr>
                  <td colspan="4"></td>
                  <td colspan="4"></td>
                  <td colspan="3"></td>
                   <td><strong></strong> </td>
                  <td><strong></strong> </td>
                  <td><strong></strong> </td>
                  <td><strong><?php echo numberFormat($netInventory); ?></strong> </td>
                </tr>

              <?php }

              }
              else
              { ?>
                  <tr><td align="center" colspan="18">No record found...</td></tr>
      <?php   } //echo "<pre>"; print_r($openingStock); echo "</pre>";?>
        </tbody>
    </table>
</div>
<div class="box-footer clearfix">
    <?php //echo $paginationLinks; ?>
</div>
