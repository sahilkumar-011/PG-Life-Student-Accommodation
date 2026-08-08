import React from 'react';

const FilterModal = props => {
  return (
    <div className="modal fade" id="filter-modal" tabIndex="-1" role="dialog" aria-labelledby="filter-heading" aria-hidden="true">
      <div className="modal-dialog modal-dialog-centered" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <h3 className="modal-title" id="filter-heading">Filters</h3>
            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div className="modal-body">
            <h5>Gender</h5>
            <hr />
            <div>
              <button className={"btn btn-outline-dark" + (props.currentFilter.gender==="none" ? " btn-active" : "")} onClick={() => props.updateFilter("none")}>
                No Filter
              </button>
              <button className={"btn btn-outline-dark" + (props.currentFilter.gender==="unisex" ? " btn-active" : "")} onClick={() => props.updateFilter("unisex")}>
                <i className="fas fa-venus-mars"></i>Unisex
              </button>
              <button className={"btn btn-outline-dark" + (props.currentFilter.gender==="male" ? " btn-active" : "")} onClick={() => props.updateFilter("male")}>
                <i className="fas fa-mars"></i>Male
              </button>
              <button className={"btn btn-outline-dark" + (props.currentFilter.gender==="female" ? " btn-active" : "")} onClick={() => props.updateFilter("female")}>
                <i className="fas fa-venus"></i>Female
              </button>
            </div>

            <h5 className="mt-4">Budget (per month)</h5>
            <hr />
            <div className="form-row">
              <div className="col">
                <label htmlFor="min-budget">Min &#8377;</label>
                <input
                  type="number"
                  min="0"
                  step="500"
                  className="form-control"
                  id="min-budget"
                  placeholder="0"
                  value={props.currentFilter.minBudget === null ? "" : props.currentFilter.minBudget}
                  onChange={e => props.updateBudget(e.target.value === "" ? null : Number(e.target.value), props.currentFilter.maxBudget)}
                />
              </div>
              <div className="col">
                <label htmlFor="max-budget">Max &#8377;</label>
                <input
                  type="number"
                  min="0"
                  step="500"
                  className="form-control"
                  id="max-budget"
                  placeholder="No limit"
                  value={props.currentFilter.maxBudget === null ? "" : props.currentFilter.maxBudget}
                  onChange={e => props.updateBudget(props.currentFilter.minBudget, e.target.value === "" ? null : Number(e.target.value))}
                />
              </div>
            </div>
          </div>

          <div className="modal-footer">
            <button type="button" className="btn btn-outline-secondary" onClick={() => { props.updateFilter("none"); props.updateBudget(null, null); }}>Clear</button>
            <button data-dismiss="modal" className="btn btn-success">Okay</button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default FilterModal;
