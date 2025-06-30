<div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{route('orders')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Orders
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Success
            </span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        nameProduct = 'Order';
        swal(nameProduct, "payment was successfull!", "success");
        setTimeout(function () {
            window.location.href = '/orders';
        }, 1500);
    });

</script>