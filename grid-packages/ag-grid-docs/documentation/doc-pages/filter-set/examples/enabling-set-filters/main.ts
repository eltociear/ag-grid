import { GridOptions } from '@ag-grid-community/core'

const gridOptions: GridOptions = {
  columnDefs: [
    // set filters
    { field: 'athlete', filter: true },
    { field: 'country', filterComp: 'agSetColumnFilter' },

    // number filters
    { field: 'gold', filterComp: 'agNumberColumnFilter' },
    { field: 'silver', filterComp: 'agNumberColumnFilter' },
    { field: 'bronze', filterComp: 'agNumberColumnFilter' },
  ],

  defaultColDef: {
    flex: 1,
    minWidth: 200,
    resizable: true,
    floatingFilter: true,
  },
}

// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function () {
  var gridDiv = document.querySelector('#myGrid')
  new agGrid.Grid(gridDiv, gridOptions)

  fetch('https://www.ag-grid.com/example-assets/olympic-winners.json')
    .then(response => response.json())
    .then(data => gridOptions.api!.setRowData(data))
})
