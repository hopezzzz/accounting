<?php $loginSessionData = $this->session->userdata('clientData');?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?php if ($parentUrl == 'dashboard') echo "active"; ?>">
                <a href="<?php echo site_url('dashboard');?>">
                    <i class="fa fa-th"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php if( empty( $loginSessionData['companyData'] ) ){ ?>
                <li class="treeview <?php if ($parentUrl == 'Client') echo "active"; ?>">
                    <a href="javascript:void();">
                        <i class="fa fa-users"></i> <span>Client Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if ($childUrl == 'Add Client') echo "active"; ?>"><a href="<?php echo site_url('add-client'); ?>"><i class="fa fa-user-plus"></i> Add Client</a></li>
                        <li class="<?php if ($childUrl == 'List Client' || $childUrl == 'Update Client' ) echo "active"; ?>"><a href="<?php echo site_url('clients'); ?>"><i class="fa fa-user"></i> Client List</a></li>
                    </ul>
                </li>
                <li class="<?php if ($parentUrl == 'Setting') echo "active"; ?>">
                    <a href="<?php echo site_url('settings');?>">
                        <i class="fa fa-cog"></i> <span>Setting</span>
                    </a>
                </li>
                <!-- <li class="<?php if ($parentUrl == 'Setting') echo "active"; ?> treeview">
                    <a href="javascript:void();">
                        <i class="fa fa-cog"></i> <span> Settings </span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="<?php if ($childUrl == 'add unit of measurement') echo "active"; ?>"><a href="<?php echo site_url('add-unit-of-measurement'); ?>"><i class="fa fa-plus"></i> Add Unit of Measurement</a></li>
                        <li class="<?php if ($childUrl == 'unit of measurement') echo "active"; ?>"><a href="<?php echo site_url('unit-of-measurement'); ?>"><i class="fa fa-list"></i> Unit of Measurement List</a></li>

                    </ul>
                </li> -->
        <?php } ?>
            <?php if( !empty( $loginSessionData['companyData'] ) ){ ?>
                <li class="<?php if ($parentUrl == 'Debtor') echo "active"; ?> treeview">
                    <a href="javascript:void();">
                        <i class="fa fa-users"></i> <span>Debtors</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if ($childUrl == 'Add Debtor') echo "active"; ?>"><a href="<?php echo site_url('add-debtor'); ?>"><i class="fa fa-user-plus"></i> Add Debtor</a></li>
                        <li class="<?php if ($childUrl == 'List Debtor') echo "active"; ?>"><a href="<?php echo site_url('debtors'); ?>"><i class="fa fa-user"></i> Debtors List</a></li>
                    </ul>
                </li>
                <li class="<?php if ($parentUrl == 'Creditor') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-users"></i> <span>Creditors</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Creditor') echo "active"; ?>"><a href="<?php echo site_url('add-creditor'); ?>"><i class="fa fa-user-plus"></i> Add Creditor</a></li>
                    <li class="<?php if ($childUrl == 'List Creditor') echo "active"; ?>"><a href="<?php echo site_url('creditors'); ?>"><i class="fa fa-user"></i> Creditor List</a></li>
                </ul>
            </li>
            <li class="<?php if ($parentUrl == 'Purchase') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-shopping-cart"></i> <span>Purchases</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Purchase') echo "active"; ?>"><a href="<?php echo site_url('add-purchase'); ?>"><i class="fa fa-plus"></i> Add Purchase</a></li>
                    <li class="<?php if ($childUrl == 'purchase') echo "active"; ?>"><a href="<?php echo site_url('purchase'); ?>"><i class="fa fa-list"></i> Purchase List</a></li>
                </ul>
            </li>
            <li class="<?php if ($parentUrl == 'Sales') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-hand-lizard-o"></i> <span>Sales</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Sale') echo "active"; ?>"><a href="<?php echo site_url('add-sale'); ?>"><i class="fa fa-exchange"></i> Add Sale</a></li>
                    <li class="<?php if ($childUrl == 'Sales') echo "active"; ?>"><a href="<?php echo site_url('sales'); ?>"><i class="fa fa-list-alt"></i> Sales List</a></li>
                </ul>
            </li>
            <li class="<?php if ($parentUrl == 'Expense') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-line-chart"></i> <span>Expense</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Expense') echo "active"; ?>"><a href="<?php echo site_url('add-expense'); ?>"><i class="fa fa-plus"></i> Add Expense</a></li>
                    <li class="<?php if ($childUrl == 'Expense') echo "active"; ?>"><a href="<?php echo site_url('expense'); ?>"><i class="fa fa-list"></i> Expense List</a></li>
                </ul>
            </li>
            <li class="<?php if ($parentUrl == 'Bank Management') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-bank"></i> <span>Bank Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Bank') echo "active"; ?>"><a href="<?php echo site_url('add-bank'); ?>"><i class="fa fa-plus"></i> Add Bank</a></li>
                    <li class="<?php if ($childUrl == 'Bank') echo "active"; ?>"><a href="<?php echo site_url('bank'); ?>"><i class="fa fa-list"></i> Bank List</a></li>
                </ul>
            </li>
            <!-- <li class="<?php if ($parentUrl == 'Cash/Bank Management') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-bank"></i> <span>Cash / Bank Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'cash-bank-transactions') echo "active"; ?>"><a href="<?php echo site_url('cash-bank-transactions'); ?>"><i class="fa fa-list"></i> Transaction List</a></li>
                </ul>
            </li> -->
            <!-- <li class="<?php if ($parentUrl == 'Borrower') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-users"></i> <span>Borrowers Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Borrower') echo "active"; ?>"><a href="<?php echo site_url('add-borrower'); ?>"><i class="fa fa-user-plus"></i> Add Borrower</a></li>
                    <li class="<?php if ($childUrl == 'List Borrower') echo "active"; ?>"><a href="<?php echo site_url('borrowers'); ?>"><i class="fa fa-user"></i> Borrower List</a></li>
                </ul>
            </li> -->

            <li class="<?php if ($parentUrl == 'Borrowing Management') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-money"></i> <span>Borrowing Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Borrowing') echo "active"; ?>"><a href="<?php echo site_url('add-borrowing'); ?>"><i class="fa fa-plus"></i> Add Borrowing</a></li>
                    <li class="<?php if ($childUrl == 'borrowings') echo "active"; ?>"><a href="<?php echo site_url('borrowings'); ?>"><i class="fa fa-list"></i> Borrowing List</a></li>
                    <li class="<?php if ($childUrl == 'List Borrower') echo "active"; ?>"><a href="<?php echo site_url('borrowers'); ?>"><i class="fa fa-user"></i> Borrower List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'Loan Management') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-money"></i> <span>Loan Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Loans') echo "active"; ?>"><a href="<?php echo site_url('add-loans'); ?>"><i class="fa fa-plus"></i> Add Loans</a></li>
                    <li class="<?php if ($childUrl == 'loans') echo "active"; ?>"><a href="<?php echo site_url('loans'); ?>"><i class="fa fa-list"></i> Loans List</a></li>
                    <li class="<?php if ($childUrl == 'List Lenders') echo "active"; ?>"><a href="<?php echo site_url('lenders'); ?>"><i class="fa fa-user"></i> Lenders List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'Share Holder') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-area-chart"></i> <span>Share Holder</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Share') echo "active"; ?>"><a href="<?php echo site_url('add-share'); ?>"><i class="fa fa-user-plus"></i> Add Share Holder</a></li>
                    <li class="<?php if ($childUrl == 'Share') echo "active"; ?>"><a href="<?php echo site_url('share'); ?>"><i class="fa fa-user-o"></i> Share Holder List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'Share Capital') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-pie-chart"></i> <span>Share Capital</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'add-share-capital') echo "active"; ?>"><a href="<?php echo site_url('add-share-capital'); ?>"><i class="fa fa-plus"></i> Add Share Capital</a></li>
                    <li class="<?php if ($childUrl == 'share-capital') echo "active"; ?>"><a href="<?php echo site_url('share-capital'); ?>"><i class="fa fa-list"></i> Share Capital List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'Journal') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-book"></i> <span>Journal</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Journal') echo "active"; ?>"><a href="<?php echo site_url('add-journal'); ?>"><i class="fa fa-plus"></i> Add Journal</a></li>
                    <li class="<?php if ($childUrl == 'Journal') echo "active"; ?>"><a href="<?php echo site_url('journal'); ?>"><i class="fa fa-list"></i> Journal List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'Accounting Management') echo "active"; ?> treeview">
                <a href="javascript:void();">
                    <i class="fa fa-link"></i> <span> Accounting </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($childUrl == 'Add Accounting') echo "active"; ?>"><a href="<?php echo site_url('add-accounting'); ?>"><i class="fa fa-plus"></i> Add Chart of account</a></li>
                    <li class="<?php if ($childUrl == 'Accounting') echo "active"; ?>"><a href="<?php echo site_url('accounting'); ?>"><i class="fa fa-list"></i> Accounts List</a></li>
                </ul>
            </li>

            <li class="<?php if ($parentUrl == 'reports') echo "active"; ?>">
                <a href="<?php echo site_url('reports');?>">
                    <i class="fa fa-line-chart"></i> <span>Reports</span>
                </a>
            </li>

            <li class="<?php if ($parentUrl == 'inventory') echo "active"; ?>">
                <a href="<?php echo site_url('inventory');?>">
                    <i class="fa fa-indent"></i> <span>Inventory Management</span>
                </a>
            </li>

            <?php } ?>
        </ul>
    </section>
</aside>
