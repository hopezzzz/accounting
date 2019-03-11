<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
            <tr>
                <th>Reference Name</th>
                <th>Payment Method</th>
                <th>Account Name</th>
                <th>Transactions Type</th>
                <th>Invoice Date</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
        <?php $GrandtotalCredit  = $GrandtotalDebit = 0;
            if (!empty($records))
            {
                foreach ($records as $key => $value) {

                    if( isset($value->vatAmount))
                        $value->amount = $value->amount + $value->vatAmount;
                    if( isset($value->discountAmountPerItem))
                        $value->amount = $value->amount - $value->discountAmountPerItem;
                    if( isset($value->vatAmount))
                        $value->amount = $value->amount - $value->commisionAmountPerItem;

                    if( isset($value->paymentRecieved) && $value->paymentRecieved > 0 && isset($value->totalItems) && $value->totalItems > 0 )
                        $value->amount = $value->amount - ( $value->paymentRecieved / $value->totalItems );
                    if ($value->transactionType == 'Journal')
                    { ?>
                        <tr id="journal_<?php echo $value->journalRef;?>">
                    <?php } else if( $value->transactionType == 'Share Capital'){ ?>
                        <tr id="sharecapital_<?php echo $value->shareCapitalRef;?>">
                    <?php } else if( $value->transactionType == 'Borrowings' || $value->transactionType == 'Loan and Advances'){ ?>
                        <tr id="Borrowings_<?php echo $value->loanRef;?>">
                    <?php } else{ ?>
                    <tr id="transaction_<?php echo $value->transactionRef;?>">
                    <?php }?>
                        <td>
                            <?php
                                if( $value->transactionType == 'Journal')
                                    echo $value->journalNumber;
                                else if($value->payeeName !='')
                                    echo ucfirst($value->payeeName);
                                else if(isset($value->payeeName1) !='')
                                    echo ucfirst($value->payeeName1);
                                else if( isset($value->bankName) != '')
                                    echo ucfirst($value->bankName);
                            ?>
                        </td>
                        <td>
                        <?php
                            if( $value->transactionType == 'Journal')
                                echo "";
                            else if( $value->transactionType == 'Borrowings' || $value->transactionType == 'Loan and Advances')
                                echo "Bank";
                            else if($value->paymentMethod == 1)
                                echo "Cash In Hand";
                            else
                                echo paymentMethodLabel($value->paymentMethod);
                        ?>
                        </td>
                        <td><?php echo ucfirst($value->subcategory); ?></td>
                        <td>
                        <?php
                            if ($value->transactionType == '1')
                            {
                                echo '<span class="label label-success">Purchase</span>';
                            }
                            else if ($value->transactionType == '2')
                            {
                                echo '<span class="label label-primary">Sale</span>';
                            }
                            else if ($value->transactionType == '3')
                            {
                                echo '<span class="label label-info">Expense</span>';
                            }
                            else if ($value->transactionType == '4')
                            {
                                echo '<span class="label label-info">Purchase Return</span>';
                            }
                            else if ($value->transactionType == '5')
                            {
                                echo '<span class="label label-info">Sale Return</span>';
                            }
                            else
                            {
                                echo '<span class="label label-info">'.$value->transactionType.'</span>';
                            }
                        ?>
                        </td>
                        <td><?php echo date('d M Y',strtotime($value->invoiceDate)); ?></td>
                        <td>
                            <?php
                                if ( $value->type == 'db')
                                    $GrandtotalDebit = $GrandtotalDebit +  $value->amount;
                                if ($value->transactionType == 'Journal' && $value->type == 'db'){ ?>
                                    <a class="mouserpointer general-ledgerJournalA" data-ref="<?php echo $value->journalNumber;?>">
                                        <?php   echo number_format($value->amount,2); ?>
                                    </a>
                            <?php } else if ($value->transactionType == 'Share Capital' && $value->type == 'db'){?>
                                    <a target="_blank" class="mouserpointer" href="<?php echo site_url('update-capital/' . $value->shareCapitalRef);?>">
                                        <?php   echo number_format($value->amount,2); ?>
                                    </a>
                            <?php } else if ($value->transactionType == 'Loan and Advances' && $value->type == 'db'){?>
                                    <a target="_blank" class="mouserpointer" href="<?php echo site_url('update-loan/' . $value->loanRef);?>">
                                        <?php   echo number_format($value->amount,2); ?>
                                    </a>
                            <?php } else if ($value->type == 'db') { ?>
                                <a target="_blank" class="session" href="<?php
                                    if ($value->transactionType == '1')
                                        echo site_url('update-purchase/' . $value->transactionRef);
                                    else if ($value->transactionType == '3')
                                        echo site_url('update-expense/' . $value->transactionRef);
                                    else if ($value->transactionType == '2')
                                            echo site_url('update-sale/' . $value->transactionRef);?>">
                                    <?php   echo number_format($value->amount,2); ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                                if ( $value->type == 'cr')
                                    $GrandtotalCredit = $GrandtotalCredit +  $value->amount;
                                if ($value->transactionType == 'Journal' && $value->type == 'cr'){?>
                                    <a class="mouserpointer general-ledgerJournalA" data-ref="<?php echo $value->journalNumber;?>">
                                        <?php   echo number_format($value->amount,2); ?>
                                    </a>
                            <?php } else if ($value->transactionType == 'Share Capital' && $value->type == 'cr'){?>
                                    <a target="_blank" class="mouserpointer" href="<?php echo site_url('update-capital/' . $value->shareCapitalRef);?>">
                                        <?php   echo number_format($value->amount,2); ?>
                                    </a>
                            <?php } else if ($value->transactionType == 'Borrowings' && $value->type == 'cr'){?>
                                <a target="_blank" class="mouserpointer " href="<?php echo site_url('update-borrowing/' . $value->loanRef);?>">
                                    <?php   echo number_format($value->amount,2); ?>
                                </a>
                            <?php } else if ($value->type == 'cr') { ?>
                                <a target="_blank" class="session" href="<?php
                                    if ($value->transactionType == '1')
                                        echo site_url('update-purchase/' . $value->transactionRef);
                                    else if ($value->transactionType == '3')
                                        echo site_url('update-expense/' . $value->transactionRef);
                                    else if ($value->transactionType == '2')
                                            echo site_url('update-sale/' . $value->transactionRef);?>">
                                    <?php   echo number_format($value->amount,2); ?>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
        <?php       if( count($records) == $key+1)
                    {
                       echo '<tr style="background:#80808033"><td colspan="4"></td><td align="left"><strong>Grand Total : </strong></td><td><strong>'.number_format($GrandtotalDebit,2).'</strong></td><td><strong>'.number_format($GrandtotalCredit,2).'</strong></td><td></td></tr>';
                    }
                }
            }
            if(empty($records) && empty($recordsJ) )
            { ?>
                <tr><td align="center" colspan="13">No records found.</td></tr>
      <?php   } ?>
        </tbody>
      </table>

</div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        jQuery(document).on('click','.general-ledgerJournalA',function()
        {
            var ref = $(this).attr('data-ref');
            if( ref == '' || ref == undefined )
            {
                $.toast({
                    heading             : 'Error',
                    text                : 'Something went wrong. Please try again.',
                    loader              : true,
                    loaderBg            : '#fff',
                    showHideTransition  : 'fade',
                    icon                : 'error',
                    hideAfter           : 2000,
                    position            : 'top-right'
                });
                localStorage.setItem('journalRef','');
            }
            else
            {
                localStorage.setItem('journalRef',ref);
                window.open(site_url+'journal/', '_blank');
            }
        });
    });

</script>
