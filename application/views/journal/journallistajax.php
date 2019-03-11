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
            <?php $journalNumber = ''; $GrandtotalDebit = $GrandtotalCredit = $totalDebit = $totalCredit = 0;
                if (!empty($records)) {
                foreach ($records as $key => $value) {
                    if( $journalNumber == '' )
                        $journalNumber = $value->journalNumber;
                        if( $journalNumber != $value->journalNumber )
                        {
                           echo '<tr style="background:#80808033"><td colspan="4"></td><td><strong>'.number_format($totalDebit,2).'</strong></td><td><strong>'.number_format($totalCredit,2).'</strong></td><td></td></tr>';
                           $totalDebit = $totalCredit = 0;
                        }
            ?>
                    <tr id="journal_<?php echo $value->journalRef;?>">
                        <td>
                            <?php
                                if( $key == 0 )
                                    echo '<strong>'.$value->journalNumber.'</strong>';
                                else if( $journalNumber != $value->journalNumber )
                                    echo '<strong>'.$value->journalNumber.'</strong>';
                            ?>
                        </td>
                        <td>
                            <?php
                                if( $key == 0 )
                                    echo changeDateFormat($value->date,'d M Y');
                                else if( $journalNumber != $value->journalNumber )
                                    echo changeDateFormat($value->date,'d M Y');
                            ?>
                        </td>
                        <td><?php echo ucfirst($value->subcategory); ?></td>
                        <td>
                            <?php if( strlen($value->description) > 30 )
                                    {
                                        echo '<span data-toggle="tooltip" title="'.$value->description.'">'.ucfirst(substr($value->description,30).' ...').'</span>';
                                    }
                                    else
                                        echo ucfirst($value->description);
                                ?>
                        </td>
                        <td>
                            <?php if( $value->type == 'db')
                            {
                                echo number_format($value->amount,2);
                                $totalDebit      = $totalDebit + $value->amount;
                                $GrandtotalDebit = $GrandtotalDebit + $value->amount;
                            }?>
                        </td>
                        <td>
                            <?php if( $value->type == 'cr')
                            {
                                echo number_format($value->amount,2);
                                $totalCredit       = $totalCredit + $value->amount;
                                $GrandtotalCredit  = $GrandtotalCredit + $value->amount;
                            }?>
                        </td>
                        <td class="addMins">
                            <?php if( $key == 0 ) {?>
                                <a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->journalRef);?>" data-type="journal" data-ref="<?php echo $value->journalRef;?>" ><i class="fa fa-trash-o iconTabFa faMin"></i></a>
                            <?php } else if( $journalNumber != $value->journalNumber ){ ?>
                                <a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->journalRef);?>" data-type="journal" data-ref="<?php echo $value->journalRef;?>" ><i class="fa fa-trash-o iconTabFa faMin"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                        if( count($records)-1 == $key)
                        {
                           echo '<tr style="background:#80808033"><td colspan="4"></td><td><strong>'.number_format($totalDebit,2).'</strong></td><td><strong>'.number_format($totalCredit,2).'</strong></td><td></td></tr>';
                           $totalDebit = $totalCredit = 0;
                        }
                        if( $journalNumber != $value->journalNumber )
                        {
                           $journalNumber = $value->journalNumber;
                        }
                        if( count($records) == $key+1)
                        {
                           echo '<tr style="background:#80808033"><td colspan="3"></td><td align="right"><strong>Grand Total : </strong></td><td><strong>'.number_format($GrandtotalDebit,2).'</strong></td><td><strong>'.number_format($GrandtotalCredit,2).'</strong></td><td></td></tr>';
                        }
                    }
                }
                else
                { ?>
                    <tr><td align="center" colspan="6">No journal found.</td></tr>
        <?php   } ?>
        </tbody>
    </table>
</div>
<div class="box-footer clearfix">
    <?php //echo $paginationLinks; ?>
</div>
