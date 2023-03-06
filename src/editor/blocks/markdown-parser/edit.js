import PropTypes from 'prop-types';

const { useEffect } = wp.element;

const Edit = ({ attributes, clientId }) => {
  useEffect(() => {
    const blocks = wp.blocks.rawHandler({ HTML: attributes.html });
    wp.data.dispatch('core/block-editor').insertBlocks(blocks);
    wp.data.dispatch('core/block-editor').removeBlock(clientId);
  }, [attributes]);

  return null;
};

Edit.propTypes = {
  attributes: PropTypes.object.isRequired,
  clientId: PropTypes.string.isRequired,
};

export default Edit;
