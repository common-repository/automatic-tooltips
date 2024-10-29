import './editor.css';

const {__} = wp.i18n;
const {registerPlugin} = wp.plugins;
const {PluginSidebar} = wp.editPost;
const {SelectControl} = wp.components;
const {withSelect, withDispatch} = wp.data;
const {Component} = wp.element;

class Automatic_Tooltips extends Component {

  constructor() {

    super(...arguments);

    /**
     * If the '_daextauttol_enable_tooltips' meta of this post is not defined get its value from the plugin options from a
     * custom endpoint of the WordPress Rest API.
     */
    if (wp.data.select('core/editor').
        getEditedPostAttribute(
            'meta')['_daextauttol_enable_tooltips'].length === 0) {

      wp.apiFetch({path: '/automatic-tooltips/v1/options', method: 'GET'}).then(
          (data) => {

            wp.data.dispatch('core/editor').editPost(
                {meta: {_daextauttol_enable_tooltips: data.daextauttol_advanced_enable_tooltips}},
            );

          },
          (err) => {

            return err;

          },
      );

    }

  }

  render() {

    const MetaBlockField = function(props) {
      return (
          <SelectControl
              label={__('Enable Tooltips', 'daextauttol')}
              value={props.metaFieldValue}
              options={[
                {value: '0', label: __('No', 'daextauttol')},
                {value: '1', label: __('Yes', 'daextauttol')},
              ]}
              onChange={function(content) {
                props.setMetaFieldValue(content);
              }}
          >
          </SelectControl>
      );
    };

    const MetaBlockFieldWithData = withSelect(function(select) {
      return {
        metaFieldValue: select('core/editor').getEditedPostAttribute('meta')
            ['_daextauttol_enable_tooltips'],
      };
    })(MetaBlockField);

    const MetaBlockFieldWithDataAndActions = withDispatch(
        function(dispatch) {
          return {
            setMetaFieldValue: function(value) {
              dispatch('core/editor').editPost(
                  {meta: {_daextauttol_enable_tooltips: value}},
              );
            },
          };
        },
    )(MetaBlockFieldWithData);

    return (
        <PluginSidebar
            name="daext-automatic-tooltips-sidebar"
            icon="testimonial"
            title={__('Automatic Tooltips', 'daextauttol')}
        >
          <div
              className="daext-automatic-tooltips-sidebar-content"
          >
            <MetaBlockFieldWithDataAndActions></MetaBlockFieldWithDataAndActions>
          </div>
        </PluginSidebar>
    );

  }

}

registerPlugin('daextauttol-automatic-tooltips', {
  render: Automatic_Tooltips,
});