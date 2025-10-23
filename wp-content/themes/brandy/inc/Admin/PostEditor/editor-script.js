(function ($) {
  $(document).ready(function () {
    const { createHigherOrderComponent } = wp.compose;
    const addStyle = wp.compose.createHigherOrderComponent((BlockListBlock) => {
      return (props) => {
        const { name, attributes } = props;

        if (name === "woocommerce/product-button") {
          const wrapperProps = props.wrapperProps ?? {};
          wrapperProps.className =
            "wp-block-button wc-block-components-product-button";

          const BlockList = React.createElement(BlockListBlock, {
            ...props,
            wrapperProps: wrapperProps,
            isSubtreeDisabled: false
          });

          return BlockList;
        }

        const BlockList = React.createElement(BlockListBlock, {
          ...props,
        });

        return BlockList;
      };
    }, "addStyle");

    wp.hooks.addFilter(
      "editor.BlockListBlock",
      "my-plugin/add-style",
      addStyle
    );
  });
})(window.jQuery);
