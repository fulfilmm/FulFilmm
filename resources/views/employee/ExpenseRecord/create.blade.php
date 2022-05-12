<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
</div>
<div class="form-group">
    <label for="amount">Amount</label>
    <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}">
</div>
<div class="form-group">
    <label for="desc">Description</label>
    <textarea name="description" id="desc" cols="30" rows="10" class="form-control">{{old('description')}}</textarea>
</div>
<div class="form-group">
    <label for="attach">Attach</label>
    <input type="file" class="form-control" name="attachment" >
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>