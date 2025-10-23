const shadowPresets = [
  {
    key: "default",
    label: wp.i18n.__("Default", "brandy"),
    shadow: {},
  },
  {
    key: "none",
    label: wp.i18n.__("None", "brandy"),
    shadow: {
      x: "0px",
      y: "0px",
      blur: "0px",
      inset: false,
      spread: "0px",
    },
  },
  {
    key: "small",
    label: wp.i18n.__("Small", "brandy"),
    shadow: {
      x: "0px",
      y: "1px",
      blur: "3px",
      spread: "0px",
      inset: false,
      color: "#000A391F",
    },
  },
  {
    key: "regular",
    label: wp.i18n.__("Regular", "brandy"),
    shadow: {
      x: "0px",
      y: "5px",
      blur: "15px",
      spread: "0px",
      inset: false,
      color: "#000A3912",
    },
  },
  {
    key: "medium",
    label: wp.i18n.__("Medium", "brandy"),
    shadow: {
      x: "0px",
      y: "15px",
      blur: "50px",
      spread: "0px",
      inset: false,
      color: "#000A391A",
    },
  },
  {
    key: "large",
    label: wp.i18n.__("Large", "brandy"),
    shadow: {
      x: "0px",
      y: "15px",
      blur: "50px",
      spread: "0px",
      inset: false,
      color: "#000A3926",
    },
  },
];

function isAvatarBlock(settings) {
  return settings?.name === "core/avatar";
}

function registerAvatarTooltipAttributes(settings) {
  if (typeof settings.attributes === "undefined") {
    return settings;
  }

  if (!isAvatarBlock(settings)) {
    return settings;
  }

  settings.attributes = Object.assign(settings.attributes, {
    hasTooltip: {
      type: "boolean",
      default: false,
    },
    tooltipColor: {
      type: "string",
      default: "#ffffff",
    },
    tooltipBackgroundColor: {
      type: "string",
      default: "#1d1e20",
    },
    tooltipBorder: {
      type: "object",
      default: {},
    },
    tooltipShadow: {
      type: "object",
      default: {
        type: "default",
        custom: false,
        inset: false,
        color: "#0000001A",
        x: "0px",
        y: "2px",
        blur: "3px",
        spread: "0px",
      },
    },
  });

  return settings;
}

wp.hooks.addFilter(
  "blocks.registerBlockType",
  "brandy/avatar-post-author-tooltip-attributes",
  registerAvatarTooltipAttributes
);

/** Display controls */

const avatarPostAuthorTooltipControls = wp.compose.createHigherOrderComponent(
  (BlockEdit) => {
    return (props) => {
      const { Fragment } = wp.element;
      const {
        PanelBody,
        ToggleControl,
        __experimentalToolsPanel,
        __experimentalToolsPanelItem,
        __experimentalBorderBoxControl,
        __experimentalVStack: VStack,
        __experimentalHStack: HStack,
        __experimentalDropdownContentWrapper: DropdownContentWrapper,
        __experimentalUnitControl: UnitControl,
        __experimentalGrid: Grid,
        __experimentalToggleGroupControl: ToggleGroupControl,
        __experimentalToggleGroupControlOption: ToggleGroupControlOption,
        ColorPalette,
        Button,
        Dropdown,
        FlexItem,
      } = wp.components;
      const { InspectorControls, PanelColorSettings } = wp.blockEditor;
      const { isSelected, attributes, setAttributes } = props;
      const { __ } = wp.i18n;
      const {
        hasTooltip,
        tooltipColor,
        tooltipBackgroundColor,
        tooltipBorder,
        tooltipShadow,
      } = attributes;
      const canAddSettings = hasTooltip != null;

      return React.createElement(
        Fragment,
        null,
        React.createElement(BlockEdit, props),
        isSelected &&
          canAddSettings &&
          React.createElement(
            InspectorControls,
            null,
            React.createElement(
              PanelBody,
              { title: __("Tooltip", "brandy") },
              React.createElement(ToggleControl, {
                label: __("Show tooltip", "brandy"),
                checked: hasTooltip ?? false,
                onChange: (value) => {
                  setAttributes({
                    hasTooltip: value,
                  });
                },
              })
            )
          ),
        hasTooltip &&
          React.createElement(
            InspectorControls,
            { group: "styles" },
            // Color controls
            React.createElement(PanelColorSettings, {
              title: __("Tooltip Color"),
              colorSettings: [
                {
                  value: tooltipColor,
                  onChange: (value) => setAttributes({ tooltipColor: value }),
                  label: __("Text color"),
                },
                {
                  value: tooltipBackgroundColor,
                  onChange: (value) =>
                    setAttributes({ tooltipBackgroundColor: value }),
                  label: __("Background color"),
                },
              ],
            }),
            // Border controls
            React.createElement(
              __experimentalToolsPanel,
              { label: __("Tooltip Border", "brandy") },
              React.createElement(
                __experimentalToolsPanelItem,
                {
                  hasValue: () => true,
                  label: __("Border", "brandy"),
                  onDeselect: () => {
                    setAttributes({ tooltipBorder: {} });
                  },
                },
                React.createElement(__experimentalBorderBoxControl, {
                  colors: wp.data.select("core/editor").getEditorSettings()
                    .colors,
                  label: __("Border", "brandy"),
                  value: tooltipBorder,
                  onChange: (value) => setAttributes({ tooltipBorder: value }),
                })
              )
            ),
            // Shadow controls
            React.createElement(
              __experimentalToolsPanel,
              { label: __("Tooltip Shadow", "brandy") },
              React.createElement(
                __experimentalToolsPanelItem,
                {
                  hasValue: () => true,
                  label: __("Drop shadow", "brandy"),
                  onDeselect: () => {
                    setAttributes({ tooltipBorder: {} });
                  },
                },
                React.createElement(Dropdown, {
                  popoverProps: {
                    placement: "left-start",
                    offset: 36,
                    shift: true,
                  },
                  className: "brandy-shadow-dropdown",
                  style: {
                    border: "1px solid rgba(0, 0, 0, 0.1)",
                    width: "100%",
                  },
                  renderToggle: ({ onToggle, isOpen }) => {
                    return React.createElement(
                      Button,
                      {
                        onClick: onToggle,
                        className: isOpen ? "is-open" : "",
                        "aria-expanded": isOpen,
                        style: {
                          width: "100%",
                        },
                      },
                      React.createElement(
                        HStack,
                        {
                          justify: "flex-start",
                        },
                        React.createElement(
                          "div",
                          {
                            style: { width: 24, height: 24 },
                          },
                          React.createElement(
                            "svg",
                            {
                              viewBox: "0 0 24 24",
                              xmlns: "http://www.w3.org/2000/svg",
                              width: 24,
                              height: 24,
                              ariaHidden: "true",
                              focusable: "false",
                            },
                            React.createElement("path", {
                              d: "M12 8c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6.5c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5zM12.8 3h-1.5v3h1.5V3zm-1.6 18h1.5v-3h-1.5v3zm6.8-9.8v1.5h3v-1.5h-3zm-12 0H3v1.5h3v-1.5zm9.7 5.6 2.1 2.1 1.1-1.1-2.1-2.1-1.1 1.1zM8.3 7.2 6.2 5.1 5.1 6.2l2.1 2.1 1.1-1.1zM5.1 17.8l1.1 1.1 2.1-2.1-1.1-1.1-2.1 2.1zM18.9 6.2l-1.1-1.1-2.1 2.1 1.1 1.1 2.1-2.1z",
                            })
                          )
                        ),
                        React.createElement(FlexItem, {
                          children: __("Drop shadow", "brandy"),
                        })
                      )
                    );
                  },
                  renderContent: () => {
                    return React.createElement(
                      DropdownContentWrapper,
                      {
                        paddingSize: "medium",
                        style: { width: 300 },
                      },
                      React.createElement(
                        VStack,
                        {
                          spacing: 4,
                        },
                        React.createElement(
                          ToggleGroupControl,
                          {
                            __nextHasNoMarginBottom: true,
                            value: tooltipShadow.custom ?? false,
                            isBlock: true,
                            hideLabelFromVision: true,
                            __next40pxDefaultSize: true,
                            onChange: (value) => {
                              setAttributes({
                                tooltipShadow: {
                                  ...tooltipShadow,
                                  custom: value,
                                },
                              });
                            },
                          },
                          React.createElement(ToggleGroupControlOption, {
                            value: false,
                            label: __("Presets", "brandy"),
                          }),
                          React.createElement(ToggleGroupControlOption, {
                            value: true,
                            label: __("Custom", "brandy"),
                          })
                        ),
                        tooltipShadow.custom &&
                          React.createElement(ColorPalette, {
                            clearable: false,
                            enableAlpha: true,
                            __experimentalIsRenderedInSidebar: true,
                            value: tooltipShadow.color,
                            onChange: (value) =>
                              setAttributes({
                                tooltipShadow: {
                                  ...tooltipShadow,
                                  color: value,
                                },
                              }),
                          }),
                        tooltipShadow.custom &&
                          React.createElement(
                            ToggleGroupControl,
                            {
                              __nextHasNoMarginBottom: true,
                              value: tooltipShadow.inset ? "inset" : "outset",
                              isBlock: true,
                              hideLabelFromVision: true,
                              __next40pxDefaultSize: true,
                              onChange: (value) =>
                                setAttributes({
                                  tooltipShadow: {
                                    ...tooltipShadow,
                                    inset: value === "inset",
                                  },
                                }),
                            },
                            React.createElement(ToggleGroupControlOption, {
                              value: "outset",
                              label: __("Outset", "brandy"),
                            }),
                            React.createElement(ToggleGroupControlOption, {
                              value: "inset",
                              label: __("Inset", "brandy"),
                            })
                          ),
                        tooltipShadow.custom &&
                          React.createElement(
                            Grid,
                            {
                              columns: 2,
                              gap: 4,
                            },
                            React.createElement(UnitControl, {
                              label: __("X Position", "brandy"),
                              value: tooltipShadow.x,
                              onChange: (value) => {
                                const isNumeric =
                                  value !== undefined &&
                                  !isNaN(parseFloat(value));
                                const nextValue = isNumeric ? value : "0px";
                                setAttributes({
                                  tooltipShadow: {
                                    ...tooltipShadow,
                                    x: nextValue,
                                  },
                                });
                              },
                            }),
                            React.createElement(UnitControl, {
                              label: __("Y Position", "brandy"),
                              value: tooltipShadow.y,
                              onChange: (value) => {
                                const isNumeric =
                                  value !== undefined &&
                                  !isNaN(parseFloat(value));
                                const nextValue = isNumeric ? value : "0px";
                                setAttributes({
                                  tooltipShadow: {
                                    ...tooltipShadow,
                                    y: nextValue,
                                  },
                                });
                              },
                            }),
                            React.createElement(UnitControl, {
                              label: __("Blur", "brandy"),
                              value: tooltipShadow.blur,
                              onChange: (value) => {
                                const isNumeric =
                                  value !== undefined &&
                                  !isNaN(parseFloat(value));
                                const nextValue = isNumeric ? value : "0px";
                                setAttributes({
                                  tooltipShadow: {
                                    ...tooltipShadow,
                                    blur: nextValue,
                                  },
                                });
                              },
                            }),
                            React.createElement(UnitControl, {
                              label: __("Spread", "brandy"),
                              value: tooltipShadow.spread,
                              onChange: (value) => {
                                const isNumeric =
                                  value !== undefined &&
                                  !isNaN(parseFloat(value));
                                const nextValue = isNumeric ? value : "0px";
                                setAttributes({
                                  tooltipShadow: {
                                    ...tooltipShadow,
                                    spread: nextValue,
                                  },
                                });
                              },
                            })
                          ),
                        !tooltipShadow.custom &&
                          React.createElement(
                            "div",
                            {
                              className: "brandy-editor-box-shadow-presets",
                              style: {
                                display: "flex",
                                flexWrap: "wrap",
                                gap: 15,
                                justifyContent: "center",
                              },
                            },
                            shadowPresets.map((preset) =>
                              React.createElement(
                                "div",
                                {
                                  key: preset.key,
                                  className: `brandy-editor-box-shadow-presets-item ${
                                    tooltipShadow.type === preset.key
                                      ? "selected"
                                      : ""
                                  }`,
                                  style: {
                                    boxShadow: `${
                                      preset.shadow.inset ? "inset" : ""
                                    } ${preset.shadow.x} ${preset.shadow.y} ${
                                      preset.shadow.blur
                                    } ${preset.shadow.spread} ${
                                      preset.shadow.color
                                    }`,
                                    ...(preset.key === "none"
                                      ? {
                                          background:
                                            "linear-gradient(-45deg, #0000 48%, #ddd 0, #ddd 52%, #0000 0);",
                                        }
                                      : {}),
                                  },
                                  onClick: () => {
                                    setAttributes({
                                      tooltipShadow: {
                                        ...tooltipShadow,
                                        type: preset.key,
                                      },
                                    });
                                  },
                                },
                                React.createElement(
                                  "span",
                                  {
                                    style: {
                                      fontSize: 10,
                                    },
                                  },
                                  preset.label
                                )
                              )
                            )
                          )
                      )
                    );
                  },
                })
              )
            )
          )
      );
    };
  },
  "avatarPostAuthorTooltipControls"
);

wp.hooks.addFilter(
  "editor.BlockEdit",
  "brandy/avatar-post-author-tooltip-controls",
  avatarPostAuthorTooltipControls
);

const addAvatarPostAuthorTooltipStyleToBlock =
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      const { attributes } = props;

      const extraWrapperProps = props.wrapperProps ?? {};

      if (attributes.hasTooltip != null) {
        extraWrapperProps.style = {
          ...extraWrapperProps.style,
          ...getStyleFromAttributes(attributes),
        };
      }

      return React.createElement(BlockListBlock, props, extraWrapperProps);
    };
  }, "addAvatarPostAuthorTooltipStyleToBlock");

wp.hooks.addFilter(
  "editor.BlockListBlock",
  "brandy/avatar-post-author-tooltip-style",
  addAvatarPostAuthorTooltipStyleToBlock
);

function getStyleFromAttributes(attributes) {
  const style = {};

  const {
    hasTooltip,
    tooltipColor,
    tooltipBackgroundColor,
    tooltipBorder,
    tooltipShadow,
  } = attributes;

  if (hasTooltip) {
    // Tooltip color
    style["--b-tooltip-color"] = tooltipColor;
    // Tooltip background color
    style["--b-tooltip-bg"] = tooltipBackgroundColor;
    // Tooltip border
    if (Object.keys(tooltipBorder ?? {}).length > 0) {
      if (Object.keys(tooltipBorder ?? {}).includes("top")) {
        ["top", "bottom", "left", "right"].forEach((aspect) => {
          style[`--b-tooltip-border-${aspect}-c`] =
            tooltipBorder[aspect].color;
          style[`--b-tooltip-border-${aspect}-w`] =
            tooltipBorder[aspect].width;
          style[`--b-tooltip-border-${aspect}-s`] =
            tooltipBorder[aspect].style;
        });
      } else {
        style[`--b-tooltip-border-c`] = tooltipBorder.color;
        style[`--b-tooltip-border-w`] = tooltipBorder.width;
        style[`--b-tooltip-border-s`] = tooltipBorder.style;
      }
    }

    // Tooltip shadow
    let shadowValue = null;
    if (tooltipShadow.custom) {
      shadowValue = tooltipShadow;
    } else if (tooltipShadow.type !== "default") {
      const preset = shadowPresets.find((p) => p.key === tooltipShadow.type);
      if (preset) {
        shadowValue = preset.shadow;
      }
    }

    if (shadowValue != null) {
      style[`--b-tooltip-shadow`] = `${
        shadowValue.inset ? "inset" : ""
      } ${shadowValue.x} ${shadowValue.y} ${shadowValue.blur} ${
        shadowValue.spread
      } ${shadowValue.color}`;
    }
  }

  return style;
}
