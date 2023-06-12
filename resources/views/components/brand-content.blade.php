    <section class="p-4">
        <table class="table">
            <tbody>
                <tr>
                    @foreach ($list_brand as $brand)
                        <td class="text-center align-middle mt-2" style="margin-right: 40px">
                            <a href="{{ route('slug.home', ['slug' => $brand->slug]) }}" class="icontext"> <img
                                    style="width:200px; height:100px;" class="img-fluid"
                                    src="{{ asset('images/brand/' . $brand->image) }}" alt="{{ $brand->image }}"></a>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        {{-- <div class="row">
            @foreach ($list_brand as $brand)
                <div class="col-md-3">
                    <a href="{{ route('slug.home', ['slug' => $brand->slug]) }}" class="icontext"> <img
                            style="width:200px; height:100px;" class="img-fluid"
                            src="{{ asset('images/brand/' . $brand->image) }}" alt="{{ $brand->image }}"></a>
                </div>
            @endforeach

        </div> --}}
    </section>
