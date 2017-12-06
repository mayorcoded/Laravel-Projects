<div id="betModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Bet</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-6">
                    <form role="form" id="form-bet-32" onsubmit="submitBet({{isset($reload)?true:''}}); return false;">
                        <div class="alert alert-success" id="success-alert" style="display: none;"></div>
                        <span id="video-error" class="error text text-danger"></span>
                        <input type="hidden" name="video_id" id="video-id">
                        <div class="form-group">
                            <label>Bet Views</label>
                            <input type="text" name="maximum_view" class="form-control" placeholder="Bet views">
                            <span id="views-error" class="error text text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Days</label>
                            <input type="text" name="expiry" class="form-control" placeholder="Bet views">
                            <span id="expiry-error" class="error text text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Bet Amount</label>
                            <input type="text" name="amount" class="form-control" placeholder="Bet views">
                            <span id="amount-error" class="error text text-danger"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Bet Now!</button>
                        </div>
                    </form>
                    <h4>Video Details</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Odds     <span class="badge odd-show-111">0.23</span>
                        </li>
                        <li class="list-group-item">
                            Amount receivable     <span class="badge amount-show-111">100000</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Video Details</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <img src="https://i.ytimg.com/vi/et9hU7QMDYU/hqdefault.jpg" id="video-img" class="img-thumbnail">
                        </li>
                        <li class="list-group-item">
                            <strong>Name: </strong> <span id="video-name">0</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Number of Views: </strong> <span id="video-views">0</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Artist: </strong> <span id="video-artist">0</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Video description: </strong> <span id="video-description">0</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>