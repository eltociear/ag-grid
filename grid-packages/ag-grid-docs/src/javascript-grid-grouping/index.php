<?php
$pageTitle = "Grouping by Row: Core Feature of our Datagrid";
$pageDescription = "Core feature of ag-Grid supporting Angular, React, Javascript and more. One such feature is Grouping by Row. Use Grouping Rows to group the data over selected dimensions. You can set the data to group by specific columns, or allow the user to drag and drop columns of their choice and have it grouped on the fly. Version 20 is available for download now, take it for a free two month trial.";
$pageKeywords = "ag-Grid Grid Grouping";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h1 class="heading-enterprise">Row Grouping</h1>

<?= videoSection("https://www.youtube.com/embed/gzqjP_kF4NI", "row-grouping-video", "Row Grouping Video Tutorial") ?>

<p class="lead">
    This page shows how to group your rows. It starts off with Auto Column Groups, the simplest way to configure row
    groups and then builds up into more advanced topics for row grouping.<br>
</p>

<h2 id="specifying-group-columns">Specifying Group Columns</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=5s", "00:05") ?>

<p>
    To group rows by a particular column, mark the column you want to group with <code>rowGroup=true</code>.
    There is no limit on the number of columns that the grid can group by.
    For example, the following will group the rows in the grid by country and then sport:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions.columnDefs = [
    { field: "country", rowGroup: true },
    { field: "sport", rowGroup: true },
];
SNIPPET
) ?>

<note>
    To allow a column to be grouped when using the <a href="../javascript-grid-tool-panel/">Tool Panel</a>
    set <code>enableRowGroup=true</code> on the required columns. Otherwise you won't be able to drag
    and drop the columns to the grouping drop zone from the Tool Panel.
</note>

<h2 id="auto-column-group">Auto Column Group</h2>

<p>
    As you can see in the example below, as soon as there is at least one active row group, the grid will provide an
    additional column for displaying the groups in a tree structure with expand/collapse navigation.
</p>

<ul class="content">
    <li>There is a group column at the left that lets you open/close the groups. It also shows the amount
    of rows grouped in brackets.</li>
    <li>Sorting works out of the box in the group column. You can test this by clicking on the group column header.</li>
    <li>The country and sport columns used for grouping are still shown as normal. You can hide them
    by adding <code>hide: true</code> to their <code>colDef</code> as illustrated in the Multi Auto Column example.</li>
</ul>

<?= grid_example('Auto Column Group', 'auto-column-group', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<h2 id="multi-auto-column-group">Multi Auto Column Group</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=68s", "01:08") ?>

<p>
    The grid also lets you automatically create one column for each individual group.
    This is achieved by setting <code>gridOptions.groupMultiAutoColumn = true</code>.
    The following example illustrates this. Note that:
</p>

<ul class="content">
    <li>There is a group column displayed for each column that we are grouping by (in this case the country and
        year columns).</li>
    <li>Sorting works out of the box in each of these group column. You can test this by clicking on the group column header.</li>
    <li>The country and sport columns used for grouping are hidden so that we don't show redundant information.
        This is done by setting <code>colDef.hide = true</code>.</li>
</ul>

<?= grid_example('Multi Auto Column Group', 'multi-auto-column-group', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2 id="configuring-auto-column">Configuring the Auto Group Column</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=150s", "02:30"); ?>

<p>
    You can specify your own configuration used by the auto group columns by providing a <code>gridOptions.autoGroupColumnDef</code>.
    This can be used to override any property as defined in the <a href="../javascript-grid-column-definitions/">Columns</a>
    documentation page
</p>

<p>
    The auto columns generated by the grid use the ag-Grid provided group cell renderer.
    This means that
    <code>gridOptions.autoGroupColumnDef</code> can also be used to pass additional properties to further customise how
    your groups are displayed.
</p>
<p>
    Check the <a href="../javascript-grid-cell-rendering/">cell rendering docs</a> to see all the available
    parameters available to configure the group cell renderer.
</p>

<p>
    The following example illustrates how you can configure the auto group columns. Note that:
</p>

<ul class="content">
    <li>
        For the purpose of simplification this example uses one Auto Row Group Column. If you were to use Multi
        Auto Group Column the configuration would be applied to all the generated columns
    </li>
    <li>
        The header name of the group column is changed by setting in <code>autoGroupColumnDef.headerName = 'CUSTOM!'</code>
    </li>
    <li>
        The count for each group is removed by setting <code>autoGroupColumnDef.cellRendererParams.suppressCount = true</code>
    </li>
    <li>
        Each group has a select box by setting <code>autoGroupColumnDef.cellRendererParams.checkbox = true</code>
    </li>
    <li>
        The group column has a custom comparator that changes the way sorting works, this is achieved by setting
        <code>autoGroupColumnDef.comparator = function (left, right){...}</code>.

        The custom comparator provided in the example changes the way the sorting works by ignoring the first letter
        of the group. To test this click on the header. When sorting desc you should see countries which second letter
        goes from Z..A, asc should show countries which second letter goes A..Z
    </li>
</ul>

<?= grid_example('Configuring the Auto Group Column', 'configuring-auto-group-column', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2>Filtering on Group Columns</h2>

<p>
    Filter on group columns is more complex than filtering on normal columns as the data inside the column
    can be a mix of data from different columns. For example if grouping by Country and Year, should the filter
    be for Year or for Country?
</p>

<p>
    For auto generated group columns, the filter will work if you specify one of
    <code>field</code>, <code>valueGetter</code> or <code>filterValueGetter</code>.
</p>

<h2>Adding Values To Leaf Nodes</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=230s", "03:50") ?>

<p>
    You may have noticed in the examples so far that the group columns don't produce values on the leaf nodes, the cells
    are empty. If you want to add values you can add a <a href="../javascript-grid-value-getters">valueGetter</a>
    or <code>field</code> to the colDef and it will be used to render the leaf node.
</p>

<p>
    A side effect of this is that filtering will now work for the columns using the field values.
</p>

<p>
    This example shows specifying <code>field</code> in the auto group column. Note the following:
</p>

<ul class="content">
    <li>
        The group column shows both groups (Country and Year) as well as Athlete at the leaf level.
    </li>
    <li>
        The field (Athlete) is used for filtering.
    </li>
</ul>

<?= grid_example('Adding Values To Leaf Nodes', 'adding-values-to-leaf-nodes', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<p>
    Adding leaf nodes data can also be achieved even if you provide your own group columns, this is illustrated
    in the following example. Note the following:
</p>

<ul class="content">
    <li>
        The first column shows the Country group only. The <colde>filterValueGetter</colde> is configured to
        return the country so that country is used for filtering.
    </li>
    <li>
        The second columns shows Year (for group levels) and Athlete (for leaf levels). Because the field is
        set, the filter will use the field value for filtering.
    </li>
    <li>
        This is an example of a case where not using auto group columns lets us add custom different behaviour to
        each of the grouping columns.
    </li>
</ul>

<?= grid_example('Adding Values To Leaf Nodes for Groups', 'adding-values-to-leaf-nodes-for-groups', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<h2>Group Cell Rendering</h2>

<p>
    If you use the default group cell renderer provided by ag-grid, there are many parameters that can be passed
    to configure its behaviour, they are all explained in the
    <a href="../javascript-grid-cell-rendering">Group Cell Renderer</a> documentation. Please have a look
    at this docs if you are interested in finding our how to change the contents that are displayed in each grouped
    cell.
</p>

<p>
    You can also configure the look &amp; feel of the expan/contract buttons by
    <a href="../javascript-grid-icons">specifying your own custom icons</a>.
</p>

<h2>Specifying Row Group Order</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=295s", "04:55") ?>

<p>
    By default, if you are using a column to display more than one group, the grid will order the groups based in
    the order in which you provide the columns. The following code snipped will group by country first, then sport
    second.
</p>

<?= createSnippet(<<<SNIPPET
columnDefs = [
    // country listed first, gets grouped first
    { headerName: "Country", field: "country", rowGroup: true },
    // sport listed second, gets grouped second
    { headerName: "Sport", field: "sport", rowGroup: true },
];
SNIPPET
) ?>

<p>
    To explicitly set the order of the grouping and not depend on the column order, use
    <code>rowGroupIndex</code> instead of <code>rowGroup</code> as follows:
</p>

<?= createSnippet(<<<SNIPPET
columnDefs = [
    // index = 1, gets grouped second
    { headerName: "Country", field: "country", rowGroupIndex: 1 },
    // index = 0, gets grouped first
    { headerName: "Sport", field: "sport", rowGroupIndex: 0 },
];
SNIPPET
) ?>

<p>
    The grid will order sort the columns based on the <code>rowGroupIndex</code>. The values
    can be any numbers that are sortable, they do NOT need to start at zero (or one) and the sequence
    can have gaps.
</p>

<note>
    Using <code>rowGroup=true</code> is simpler and what most people will prefer using.
    You will notice that <code>rowGroupIndex</code> is used by the column API <code>getColumnState()</code>
    method as this cannot depend on the order of the column definitions.
</note>

<p>
    The following examples shows using <code>rowGroupIndex</code> to set the order of the group columns.
    Year is grouped first and Country is grouped second.
</p>

<?= grid_example('Row Group Index', 'row-group-index', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2>Hide Open Parents</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=348s", "05:48") ?>

<p>
    Depending on your preference, you may wish to hide parent rows when they are open.
    This gives the impression to the user that the children takes the place of the
    parent row. This feature only makes sense when groups are in different columns.
    To turn this feature on set <code>groupHideOpenParents=true</code>.
</p>

<p>
    Below shows examples of this. Notice that each group row has
    <a href="../javascript-grid-aggregation/">aggregated values</a> which are explained in
    a documentation page of their own. When the group
    is closed, the group row shows the aggregated result. When the group is open,
    the group row is removed and in its place the child rows are displayed.
    To allow closing the group again, the group column knows to display the parent
    group in the group column only (so you can click on the icon to close the group).
</p>

<p>
    The example below demonstrates hiding open parents using auto group columns.
    To help demonstrate, the grid is configured to shade the rows different colors
    for the different group levels, so when you open a group, you can see the background
    change indicating that the group row is no longer display, instead the children
    are in it's place.
</p>

<p>
    Filter is achieved for each column by providing a <code>filterValueGetter</code>
    for the <code>autoGroupColumnDef</code>. The filterValueGetter returns the value of
    the grouped column - eg for Country, it will filter on Country.
</p>

<?= grid_example('Hide Open Parents', 'hide-open-parents', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<h2 id="keepingColumnsVisible">Keeping Columns Visible</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=417s", "06:57") ?>

<p>
    By default dragging a column out of the grid will make it hidden and
    un-grouping a column will make it visible again. This default behaviour
    can be changed with the following properties:
    <ul>
        <li>
            <code>suppressDragLeaveHidesColumns</code>: When dragging a column
            out of the grid, eg when dragging a column from the grid to the group
            drop zone, the column will remain visible.
        </li>
        <li>
            <code>suppressMakeColumnVisibleAfterUnGroup</code>: When un-grouping,
            eg when clicking the 'x' on a column in the drop zone, the column will
            not be made visible.
        </li>
    </ul>
    The default behaviour is more natural for most scenarios as it stops data
    appearing twice. E.g. if country is displayed in group column, there is no
    need to display country again in the country column.
</p>

<p>
    The example below demonstrates these two properties. Note the following:
    <ul>
        <li>
            Columns country and year can be grouped by dragging the column
            to the group drop zone.
        </li>
        <li>
            Grouped columns can be un-grouped by clicking the 'x' on the column
            in the drop zone.
        </li>
        <li>
            The column visibility is not changed while the columns are grouped
            and un-grouped.
        </li>
        <li>
            While dragging the column header over the drop zone, before it is
            dropped, the column appears translucent to indicate that the grouping
            has not yet been applied.
        </li>
    </ul>
</p>

<?= grid_example('Keep Columns Visible', 'keep-columns-visible', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2 id="fullWidthRows">Full Width Group Rows</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=500s", "08:20"); ?>

<p>
    Instead of having a column for showing the groups, you can dedicate the full row for showing
    details about the group. This can be preferred if you have a lot of information you want to
    say about the group.
</p>

<p>
    The following example shows the first example in this page, the Auto Column Group example, using full width rows.
    Note that all that is necessary to achieve this it to add <code>groupUseEntireRow:true</code> to your gridOptions
</p>

<?= grid_example('Full Width Group Rows', 'full-width-group-rows', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2>Full Width Groups Rendering</h2>

<p>
    It is possible to override the rendering of the group row using <code>groupRowRenderer</code> and
    <code>groupRowInnerRenderer</code>. Use groupRowRenderer to take full control of the row rendering,
    and provide a cellRenderer exactly how you would provide one for custom rendering of cells
    for non-groups.
</p>

<p>
    The following pieces of code do the exact same thing:
</p>

<?= createSnippet(<<<SNIPPET
// option 1 - tell the grid to group by row, the grid defaults to using
// the default group cell renderer for the row with default settings.
gridOptions.groupUseEntireRow = true;
SNIPPET
) ?>

<?= createSnippet(<<<SNIPPET
// option 2 - this does the exact same as the above, except we configure
// it explicitly rather than letting the grid choose the defaults.
// we tell the grid what renderer to use (the built in renderer) and we
// configure the default renderer with our own inner renderer
gridOptions.groupUseEntireRow = true;
gridOptions.groupRowRenderer = 'agGroupCellRenderer';
gridOptions.groupRowRendererParams = {
    innerRenderer: function(params) { return params.node.key; },
};
SNIPPET
) ?>

<?= createSnippet(<<<SNIPPET
// option 3 - again the exact same. we allow the grid to choose the group
// cell renderer, but we provide our own inner renderer.
gridOptions.groupUseEntireRow = true;
gridOptions.groupRowInnerRenderer = function(params) { return params.node.key; };
SNIPPET
) ?>

<p>
    The above probably reads a bit confusing. So here are rules to help you choose:
</p>

<ul class="content">
    <li>
        If you are happy with what you get with just setting groupUseEntireRow = true,
        then stick with that, don't bother with the renderers.
    </li>
    <li>
        If you want to change the inside of the renderer, but are happy with the
        expand / collapse etc of the group row, then just set the groupRowInnerRenderer.
    </li>
    <li>
        If you want to customise the entire row, you are not happy with what you
        get for free with the group cell renderer, then set your own renderer
        with groupRowRenderer, or use groupRowRenderer to configure the default
        group renderer.
    </li>
</ul>

<p>
    Here is an example of taking full control, creating your own renderer. In practice,
    this example is a bit useless, as you will need to add functionality to at least expand
    and collapse the group, however it demonstrates the configuration:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions.groupUseEntireRow = true;
gridOptions.groupRowRenderer = function(params) { return params.node.key; };
SNIPPET
) ?>

<p>
    This example takes full control also, but uses the provided group renderer
    but configured differently by asking for a checkbox for selection:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions.groupUseEntireRow = true;
gridOptions.groupRowRenderer = 'agGroupCellRenderer';
gridOptions.groupRowRendererParams = {
    checkbox: true,
    // innerRenderer is optional, we could leave this out and use the default
    innerRenderer: function(params) { return params.node.key; },
}
SNIPPET
) ?>

<p>
    Below shows an example of aggregating with full width rows for groups. The following can be noted:
</p>

<ul>
    <li>
        Each group spans the width of the grid.
    </li>
    <li>
        Each group uses a custom Cell Renderer. The cell renderer shows the aggregation data for each medal type.
    </li>
    <li>
        Each medal column is editable, you can change the number of medals for any of the athletes.
    </li>
    <li>
        The column Year has a filter on it.
    </li>
    <li>
        The cell renderer has logic listening for changes to filtering and data cell changes*. This means the
        aggregation data in the full with row is updated if:
        <ol>
            <li>If you edit any cell</li>
            <li>If you filter the data (ie take rows out).</li>
        </ol>
    </li>
</ul>

<p>
    <i>
        * This is true for Vanilla Javascript and React. Angular uses data binding and thus the aggregation data
        updates automatically without needing to listen to events.
    </i>
</p>

<?= grid_example('Full Width Groups Rendering', 'full-width-groups-rendering', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules' => ['clientside', 'rowgrouping'], 'extras' => ['fontawesome'], 'reactFunctional' => true]) ?>

<h2 id="default-group-order">Default Group Order</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=614s", "10:14") ?>

<p>
    The grid does not attempt to order the groups. The groups are presented on a 'first come, first served'
    basis. For example if grouping by country, and the first row is for country 'Ireland', then the first
    displayed group will be 'Ireland'.
</p>

<p>
    For most scenarios, this will not be a problem as the user can sort the grouping column. However this
    will be a problem in one of the following cases:
    <ul>
        <li>
            The grid is using <a href="#fullWidthRows">Full Width Group Rows</a>, which means there is no
            columns associated with the groups to order.
        </li>
        <li>
            The groups have an implied order that should not require column sorting to achieve. For example
            grouping by month (January, February...) or other groups which have business meaning that require
            order e.g. ["Severe", "Medium", "Low"] or ["Today", "Yesterday", "Older than 1 day"].
        </li>
    </ul>
</p>

<p>
    To provide a group order, you should supply <code>defaultGroupSortComparator</code> callback to
    the grid. The callback is a standard JavaScript Array comparator that takes two values and
    compares them.
</p>

<p>
    The example below shows providing a default group order. From the example the following can be noted:
    <ul>
        <li>Groups are displayed using full width rows. There is no column to click to sort the groups.</li>
        <li>The grid is provided with <code>defaultGroupSortComparator</code>.</li>
        <li>Groups are sorted alphabetically.</li>
    </ul>
</p>

<?= grid_example('Default Group Order', 'default-group-order', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2 id="unbalanced-groups">Unbalanced Groups</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=691s", "11:31") ?>

<p>
    If there are rows containing <code>null</code> or <code>undefined</code> values for the column that is being
    grouped then these rows will not be grouped. We refer to this scenario as <strong>Unbalanced Groups</strong> in that
    there is a mix of groups and rows as siblings. The following example demonstrates:
</p>

<ul class="content">
    <li>Data is grouped by column 'State'. Rows are either grouped by state 'New York', 'California' or
        not grouped.</li>
    <li>Removing the grouping shows that the non grouped rows have no 'State' value.</li>
</ul>

<?= grid_example('Unbalanced Groups', 'unbalanced-groups', 'generated', ['enterprise' => true, 'exampleHeight' => 570, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<p>
    If you do not want rows with null or undefined to be left out of groups, but want
    a group created to contain these empty values, then change your data and replace the null and undefined
    values with something (eg the string 'Empty' or a string with a blank space character i.e. ' ').
</p>

<h2>Expanding Rows via API</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=750s", "12:30") ?>

<p>
    To expand or contract a group via the API, you first must get a reference to the rowNode and then call
    <code>rowNode.setExpanded(boolean)</code>. This will result in the grid getting updated and displaying the
    correct rows. For example, to expand a group with the name 'Zimbabwe' would be done as follows:
</p>

<?= createSnippet(<<<SNIPPET
gridOptions.api.forEachNode(function(node) {
    if (node.key === 'Zimbabwe') {
        node.setExpanded(true);
    }
});
SNIPPET
) ?>

<p>
    Calling <code>node.setExpanded()</code> causes the grid to get redrawn. If you have many nodes you want to
    expand, then it is best to set node.expanded=true directly, and then call
    <code>api.onGroupExpandedOrCollapsed()</code> when finished to get the grid to redraw the grid again just once.
</p>

<h2>Grouping Complex Objects with Keys</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=817s", "13:37") ?>

<p>
    If your rowData has complex objects that you want to group by, then the default grouping
    will convert each object to <code>"[object object]"</code> which will be useless to you. Instead
    you need to get the grid to convert each object into a meaningful string to act as the key
    for the group. You could add a 'toString' method to the objects - but this may not be possible
    if you are working with JSON data. To get around this, use <code>colDef.keyCreator</code>, which
    gets passed a value and should return the string key for that value.
</p>

<p>
    The example below shows grouping on the county, with country an object within each row.
</p>

<?= createSnippet(<<<SNIPPET
// row item has complex object for country
rowItem = {
    athlete: 'Michael Phelps',
    country: {
        name: 'United States',
        code: 'US'
    }
    ....
}

// the column definition for country has keyCreator
colDef = {
    headerName: "Country",
    field: "country",
    keyCreator: function(params) {
        return params.value.name;
    }
    ...
}
SNIPPET
) ?>

<?= grid_example('Grouping Complex Objects with Keys', 'grouping-complex-objects', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<h2 id="grouping-footers">Grouping Footers</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=929s", "15:29") ?>

<p>
    If you want to include a footer with each group, set the property <code>groupIncludeFooter</code> to true.
    The footer is displayed as the last line of the group when the group is expanded - it is not displayed
    when the group is collapsed.
</p>
<p>
    The footer by default will display the word 'Total' followed by the group key. If this is not what you
    want, then use the <code>footerValueGetter</code> option. The following shows two snippets for achieving
    the same, one using a function, one using an expression.
</p>

<?= createSnippet(<<<SNIPPET
// use a function to return a footer value
cellRenderer: 'agGroupCellRenderer',
cellRendererParams: {
    footerValueGetter: function(params) { return 'Total (' + params.value + ')'; },
}}

// use an expression to return a footer value. this gives the same result as above
cellRenderer: 'agGroupCellRenderer',
cellRendererParams: {
    footerValueGetter: '"Total (" + x + ")"'
}}
SNIPPET
) ?>

<p>
    When showing the groups in one column, the aggregation data is displayed
    in the group header when collapsed and only in the footer when expanded (ie it moves from the header
    to the footer). To have different rendering, provide a custom <code>groupInnerCellRenderer</code>, where
    the renderer can check if it's a header or footer.
</p>

<p>
    It is also possible to include a 'grand' total footer for all groups using the property <code>groupIncludeTotalFooter</code>.
    This property can be used along side <code>groupIncludeFooter</code> to produce totals at all group levels or
    used independently.
</p>

<p>
    The example below uses <a href="../javascript-grid-aggregation/">aggregation</a> which is explained in
    the next section but included here as footer rows only make sense when used with aggregation. In this example
    notice:
</p>

<ul class="content">
    <li><code>gridOptions.groupIncludeFooter = true</code> -  includes group totals within each group level.</li>
    <li><code>gridOptions.groupIncludeTotalFooter = true</code> -  includes a 'grand' total across all groups.</li>
</ul>

<?= grid_example('Group Footers', 'grouping-footers', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<note>
    Group footers are a UI concept only in the grid. It is the grids way of showing aggregated data (which belongs
    to the group) appearing after the group's children. Because the footer is a UI concept only, the following
    should be noted:
    <ul>
        <li>It is not possible to select footer nodes. Footer rows appear selected when the group is selected.</li>
        <li>Footer rows are not parted of the iterated set when the api method <code>api.forEachNode()</code> is called.</li>
        <li>Footer nodes are not exported to CSV or Excel.</li>
    </ul>
</note>

<h2 id="keeping-group-state">Keeping Group State</h2>

<p>
    <note>
        If using <a href="../javascript-grid-data-update-transactions/">Transactions</a> or
        <a href="../javascript-grid-immutable-data/">Immutable Data</a>, then
        you do not need to be concerned with keeping group state. When using transactions or delta updates,
        the group state is not changed.
    </note>
</p>

<p>
    When you set new data into the group by default all the group open/closed states are reset.
    If you want to keep the original state, then set the property <code>rememberGroupStateWhenNewData=true</code>.
    The example below demonstrates this. Only half the data is shown in the grid at any given time,
    either the odd rows or the even rows. Hitting the 'Refresh Data' will set the data to 'the other half'.
    Note that not all groups are present in both sets (eg 'Afghanistan' is only present in one group) and
    as such the state is not maintained. A group like 'Australia' is in both sets and is maintained.
</p>

<?= grid_example('Keeping Group State', 'keeping-group-state', 'generated', ['enterprise' => true, 'exampleHeight' => 540, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<h2 id="removeSingleChildren">Removing Single Children</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=1029s", "17:09") ?>

<p>
    If your data has groups with only one child, then it can make sense to collapse
    these groups as there is no benefit to the user creating groups with just one child,
    it's arguably waste of space.
</p>

<p>
    To turn this feature on set either <code>groupRemoveSingleChildren=true</code>
    or <code>groupRemoveLowestSingleChildren=true</code>.
</p>

<ul class="content">
    <li><b>groupRemoveSingleChildren:</b> Removes groups from display if they only have one child.</li>
    <li><b>groupRemoveLowestSingleChildren:</b> Removes groups from display if they only have one child and
        the groups is at the lowest level (ie contains leaf nodes).</li>
</ul>

<p>
    The example below shows this feature. Note the following:
    <ul class="content">
        <li>
            <b>Normal:</b> Shows the rows as normal, nothing is removed. All groups have their children
            count in brackets after the group.
        </li>
        <li>
            <b>Remove Single Children:</b> Removes single children using the property
            <code>groupRemoveSingleChildren=true</code>. All groups with just one child
            are remove.
        </li>
        <li>
            <b>Remove Lowest Single Children:</b> Removes single children using the property
            <code>groupRemoveLowestSingleChildren=true</code>. All groups for the 'City' column with just one child
            are remove. The 'City' column is the lowest level group, so it's the only group candidate to be
            removed when one child.
        </li>
    </ul>
</p>

<?= grid_example('Removing Single Children', 'remove-single-children', 'vanilla', ['enterprise' => true, 'exampleHeight' => 540, 'modules'=>['clientside', 'rowgrouping', 'menu', 'columnpanel', 'setfilter'], 'reactFunctional' => true]) ?>

<note>
    Filtering does not impact what groups get removed. For example if you have a group with two
    children, the group is not removed, even if you apply a filter that removes one of the children.
    This is because ag-Grid does grouping first and then applies filters second. If you change the filter,
    only the filter is reapplied, the grouping is not reapplied.
</note>


<note>
    The properties <code>groupRemoveSingleChildren</code>, <code>groupRemoveLowestSingleChildren</code>
    and <code>groupHideOpenParents</code> are mutually exclusive, you can only pick one.
    Technically it doesn't make sense to mix these. They don't work together as the logic for removing single
    children clashes with the logic for hiding open parents. Both want to remove parents at different times
    and for different reasons.
</note>

<h2 id="showRowGroup">Creating Your Own Group Display Columns</h2>

<?= videoLink("https://www.youtube.com/watch?v=gzqjP_kF4NI&t=1136s", "18:56") ?>

<p>
    In all the previous examples the grid is in charge of generating the column's that display the groups, these columns
    are called auto group columns.
</p>

<p>
    You can prevent the generation of the auto group columns and take control over which columns display which groups.
    This is useful if you want to have a finer control over how your groups are displayed.
</p>

<note>
    We advise against using your own group columns. Only do this if the Auto Group Columns do not meet
    your requirements. Otherwise defining your own group columns will add unnecessary complexity to your code.
</note>

<p>
    To disable the auto group columns set <code>gridOptions.groupSuppressAutoColumn = true</code>. When you do this,
    you will be in charge of configuring which columns show which groups.
</p>

<p>
    In order to make a column display a group, you need to configure the property <code>coldef.showRowGroup</code> for that
    column.
</p>

<p>
    <code>coldef.showRowGroup</code> can be configured in two different fashions.
</p>

<ul class="content">
    <li>To tell this column to show all the groups: <code>coldef.showRowGroup= true</code></li>
    <li>To tell this column to show the grouping for a particular column. If you want to do this you need to
        know the <code>colId</code> of the column that you want to show the group by and set <code>coldef.showRowGroup= colId</code></li>
</ul>

<p>
    If you do specify <code>coldef.showRowGroup</code> you are going to also tell this column how to display the contents
    of this group, the easiest way to do this is by using the out of the box
    <a href="../javascript-grid-cell-rendering">group cell renderer</a> <code>cellRenderer:'agGroupCellRenderer'</code>
</p>

<p>
    This illustrates how to configure an specific column to show the groups generated by the country column
</p>

<?= createSnippet(<<<SNIPPET
coldefs:[
    // The column we are grouping by, it is also hidden.
    { headerName: "Country", field: "country", width: 120, rowGroup: true, hide: true },
    // We appoint this column as the column to show the country groups.
    // note that we need to provide an appropriate cell renderer.
    // in this case we are using the out of the box group cell renderer.
    { headerName: "Country - group", showRowGroup: 'country', width: 120, cellRenderer: 'agGroupCellRenderer' },
]
SNIPPET
) ?>

<p>The following example shows how to appoint individual columns to show individual groups</p>

<?= grid_example('Custom Grouping Many Group Columns', 'custom-grouping-many-group-columns', 'generated', ['enterprise' => true, 'exampleHeight' => 515, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<p>The following example shows how to display all the groups in a single column</p>

<?= grid_example('Custom Grouping Single Group Column', 'custom-grouping-single-group-column', 'generated', ['enterprise' => true, 'exampleHeight' => 505, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<p>
    The last example of explicitly setting groups shows an alternative for Hide Open Parents.
    The example below demonstrates hiding open parents using explicit group columns.
</p>

<?= grid_example('Custom Grouping Hidden Parents', 'custom-grouping-hidden-parents', 'generated', ['enterprise' => true, 'exampleHeight' => 550, 'modules'=>['clientside', 'rowgrouping'], 'reactFunctional' => true]) ?>

<note>Remember these examples are achieving the same that you can achieve with
    the auto groups columns, but their configuration is not as straight forward. We are keeping this for edge cases
    and for backwards compatibility for when we only supported this style of configuration.</note>

<h2>Grid Grouping Properties</h2>

<p>
    Grouping has the following grid properties (set these as grid properties, i.e. on <code>gridOptions</code>, not on the columns):
</p>

<?php createDocumentationFromFile('../javascript-grid-properties/properties.json', 'rowGrouping') ?>

<?php createDocumentationFromFile('apiReference.json') ?>

<?php include '../documentation-main/documentation_footer.php';?>
