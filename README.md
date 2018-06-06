#whm-acctng

<h3>June 6, 2018</h3>
<ul>
    <li>Modified Modal.vue component</li>
    <li>Added TimeLogApi</li>
    <li>Changed the TimeLog app's logic</li>
    <li>TimeLog app is now using ajax calls</li>
</ul>

<h3>June 5, 2018</h3>
<ul>
    <li>Added Payroll module and it is integrated into Employees module</li>
    <li>Payroll module with CRUD</li>
</ul>

<h3>June 4, 2018</h3>
<ul>
    <li>Integrated Time Log App</li>
    <li>Added confirmation modals to login logout</li>
    <li>Changed the time app's timezone to Asia/Manila</li>
</ul>

<h3>May 31, 2018</h3>
<ul>
    <li>Modified expense and check voucher template, added logo</li>
    <li>Added logo option on settings</li>
    <li>Modified settings logic when saving and editing</li>
    <li>Added Purchase Module, with approve and reject, CRUD</li>
</ul>

<h3>May 30, 2018</h3>
<ul>
    <li>Moved printer modal to a includable component</li>
    <li>Changed tooltips text</li>
    <li>Moved \App\Checker to \App\Services\PermissionChecker and added it to Aliases, to use just call \PermissionChecker::method()</li>
    <li>Changed dropdown toggles and added animation</li>
    <li>Added keyboard shortcut sample, use Alt + Shift + Z to toggle sidenav</li>
    <li>Replaced old Settings Module that was installed using composer, the new Settings Module was created natively</li>
    <li>Removed all the __construct in each controller and replaced by using Route::group that uses auth middleware</li>
    <li>Added Settings</li>
    <li>Added Admin Settings, to add new options that can be displayed on Settings page</li>
    <li>Created a Service called SettingsModule that can be used globally just use this \Setting::method()</li>
    <li>Created a new migration for the new settings module</li>
</ul>

<h3>May 29, 2018</h3>
<ul>
    <li>Added Settings Module</li>
    <li>Added Print Check</li>
    <li>Modified migrations</li>
    <li>Added new layout for check voucer</li>
    <li>Can now print Check</li>
</ul>

<h3>May 28, 2018</h3>
<ul>
    <li>Added relationships function to models</li>
    <li>Removed request funds</li>
    <li>Fixed styling for mobile</li>
</ul>

<h3>May 24, 2018</h3>
<ul>
    <li>Fixed layout</li>
    <li>Tried adding Pay Bill module</li>
    <li>Proper active links, indicates the current page</li>
    <li>Added styling for sidenav and the content</li>
</ul>

<h3>May 22, 2018</h3>
<ul>
    <li>Modified and created new structure for expenses, separated old expenses meta into new table called expenses details</li>
    <li>expenses meta will be used only for additional property of an expense; expense details will be used for particulars</li>
    <li>Changed the layout for the whole app, added sidenav</li>
    <li>Added Bill and Check that does the same thing functionalities with Expense</li>
    <li>Modified migrations; Added more permissions</li>
    <li>Added a sample voucher layout</li>
</ul>

<h3>May 21, 2018</h3>
<ul>
    <li>Added where clause for attachment method on Expenses model</li>
    <li>Added a ajax to display balance of a bank account when choosing a bank account (on Expense form)</li>
    <li>Tried changing the layout, moving the nav into sidenav</li>
    <li>Added Payee module with CRUD</li>
    <li>Tried adding Voucher templates</li>
    <li>Added a manipulation for expenses table (migration file)</li>
</ul>

<h3>May 18, 2018</h3>
<ul>
    <li>Added permissions</li>
    <li>Can now delete files attached to an expense</li>
    <li>Edited the attachments table</li>
    <li>Displays links of the files attached instead of showing images when viewing a single expense</li>
    <li>Unauthenticated users can't access modules (Added on banks, payment method, and expenses)</li>
</ul>

<h3>May 17, 2018</h3>
<ul>
    <li>Added file attachment on Expense form</li>
    <li>Edited banks table</li>
    <li>Added Attachments table</li>
    <li>Each expense can now have attached file</li>
</ul>

<h3>May 16, 2018</h3>
<ul>
    <li>Added Expenses, to record (can now be used)</li>
    <li>Integrated the functionalities of Request Funds into Expenses</li>
    <li>Fixed api error, Internal Server Error for Request Funds and Expenses</li>
    <li>Changed the Home page and added some links</li>
    <li>Fixed migration for permissions and Expenses</li>
</ul>

<h3>May 15, 2018</h3>
<ul>
    <li>Fixed issues on Save and Update for Users module</li>
    <li>Fixed not storing description of bank upon creating</li>
    <li>Fixed particulars not properly aligned according to its index (order)</li>
    <li>Added Payment Method with CRUD</li>
    <li>Added balance for Bank</li>
    <li>Added a FullModal component for Vue</li>
    <li>Added Migration, Resource and Controller for Payment Method</li>
    <li>Added permissions for payment_method</li>
    <li>Tried adding the functionalities of Request Funds into Expenses</li>
</ul>


<h3>May 9, 2018</h3>
<ul>
    <li>Applied the coding convention for Vue JS + Laravel</li>
    <li>Fixed issues when trying to apply coding conventions</li>
    <li>Created Migration, Model and Resource for Expenses|_meta and Banks; Also controller and its views</li>
    <li>Added npm install for Vue js components, in order to compile scss, and js</li>
    <li>Moved Request Funds into a subfolder called Disbursements, also its views</li>
    <li>Added CRUD for Bank module</li>
    <li>Changed the layout of Dashboard</li>
    <li>Started to add Expenses to record, still on data|UI designing</li>
    <li>Added a reusable component called Modal.vue</li>
    <li>Fixed fatal issues in both multi-create view and edit for Request Funds when trying to apply the coding conventions</li>
</ul>

<h3>May 4, 2018</h3>
<ul>
    <li>Changed the datatype of approved column to integer</li>
    <li>Added a dashboard content</li>
    <li>Getting started to add controllers to disbursement module</li>
    <li>Moved the other controllers into a subfolder called Disbursement to make it more organized</li>
</ul>

<h3>May 2, 2018</h3>
<ul>
    <li>Added a modal global component into Vue JS called b-modal</li>
    <li>Added a confirmation message to every delete function, uses modal</li>
    <li>Added an edit functionality to Users module</li>
    <li>Restrict a user to only edit their own account</li>
    <li>Role column added to users.index</li>
    <li>Removed Role dropdown if a current user role is permitted to see it</li>
</ul>

<h3>April 30, 2018</h3>
<ul>
    <li>Added Users, able to add new users</li>
    <li>Added user roles with permissions</li>
    <li>Can add new user roles</li>
    <li>Can assign permissions to a role</li>
    <li>If a role is not permitted to a page then it will display a message saying 'You do not have the permission to access this page'</li>
    <li>Fixed some issues regarding assigning permissions on a role</li>
    <li>Added a dropdown, to choose a role in Create a User form</li>
    <li>Fixed issues regarding php artisan migrate & migrate:*</li>
</ul>

<h3>April 27, 2018</h3>
<ul>
    <li>Moved the Add new row button, from top now its in each row.</li>
    <li>Changed the default view of Create Request Funds to Multiple</li>
    <li>After logging in, will show 3x3 grid of main functions</li>
    <li>Display of Request Funds, changed the schema, Request Fund to many particulars</li>
    <li>Added a delete and edit functionality to Request Funds,</li>
    <li>Syncs properly when manipulating a Request Fund</li>
</ul>

<h3>April 28, 2017</h3>
<ul>
    <li>Added Multi fields on create Request Funds</li>
    <li>Added JSWI global object variable in js, for reusable functions.</li>
</ul>

<h3>April 25, 2018</h3> 
<ul>
    <li>Merge the Chart of Accounts</li>
    <li>Tried adding Request Funds from the Office PC repo</li>
   <li>Merged the Charts and Request Funds feature</li>
</ul>