const { PluginDocumentSettingPanel } = wp.editPost;
const {
  PanelRow,
  DatePicker,
  ToggleControl,
  SelectControl,
  __experimentalNumberControl: NumberControl,
  __experimentalText: Text,
  __experimentalVStack: VStack,
  __experimentalHStack: HStack,
} = wp.components;
const { useEntityProp } = wp.coreData;
const { useSelect } = wp.data;
const { __ } = wp.i18n;
const { useState, useEffect } = wp.element;

/** Adds the date selector to the post settings */
function CustomBlockFields() {
  const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);
  if (postType !== 'release-note') return null;

  const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
  const { version, release_date: releaseDate } = meta;

  const [versionObject, setVersionObject] = useState({});

  /**
   * Splits the version string into an object
   */
  const splitVersion = () => {
    const prerelease = version.split('-');
    const versionArray = prerelease[0].split('.');
    const prereleaseVersion = prerelease[1] ? prerelease[1].split('.')[1] : '';
    const prereleaseType = prerelease[1] ? prerelease[1].split('.')[0] : '';

    setVersionObject({
      major: versionArray[0],
      minor: versionArray[1],
      patch: versionArray[2],
      prerelease: prereleaseType,
      prerelease_version: prereleaseVersion,
    });
  }

  /**
   * Updates the version object
   *
   * @param {integer || string} val value
   * @param {string} key key
   */
  const onVersionChange = (val, key) => {
    const tempVersionObject = { ...versionObject };
    tempVersionObject[key] = val;

    let versionString = `${tempVersionObject.major}.${tempVersionObject.minor}.${tempVersionObject.patch}`;

    if (tempVersionObject.prerelease) {
      versionString += `-${tempVersionObject.prerelease}`;
      if (tempVersionObject.prerelease_version) {
        versionString += `.${tempVersionObject.prerelease_version}`;
      }
    }

    setVersionObject(tempVersionObject);
    setMeta({ ...meta, version: versionString });
  };

  const onDateChange = (val) => {
    setMeta({ ...meta, release_date: val });
  };

  useEffect( () => {
    splitVersion();
  }, []);

  return (
    <>
      <PluginDocumentSettingPanel initialOpen name="release-notes" title="Release Info">
        <PanelRow>
          <HStack>
            <NumberControl
              shiftStep={1}
              min={0}
              value={versionObject.major}
              onChange={(val) => onVersionChange(val, 'major')}
              spinControls="none"
            />
            <Text variant="label">.</Text>
            <NumberControl
              shiftStep={1}
              min={0}
              value={versionObject.minor}
              onChange={(val) => onVersionChange(val, 'minor')}
              spinControls="none"
            />
            <Text variant="label">.</Text>
            <NumberControl
              shiftStep={1}
              min={0}
              value={versionObject.patch}
              onChange={(val) => onVersionChange(val, 'patch')}
              spinControls="none"
            />
            <SelectControl
              className="release-notes__prerelease"
              value={versionObject.prerelease}
              options={[
                { label: 'None', value: '' },
                { label: '-Alpha', value: 'alpha' },
                { label: '-Beta', value: 'beta' },
                { label: '-RC', value: 'rc' },
              ]}
              onChange={(val) => onVersionChange(val, 'prerelease')}
            />
            {versionObject.prerelease && (
              <>
                <Text variant="label">.</Text>
                <NumberControl
                  shiftStep={1}
                  min={0}
                  value={versionObject.prerelease_version}
                  onChange={(val) => onVersionChange(val, 'prerelease_version')}
                  spinControls="none"
                />
              </>
            )}
          </HStack>
        </PanelRow>
        <br />
        <PanelRow>
          <VStack>
            <Text variant="label">{__('Release Date')}</Text>
            <DatePicker
              currentDate={releaseDate}
              onChange={(val) => onDateChange(new Date(val).toISOString().split('T')[0])}
            />
          </VStack>
        </PanelRow>
      </PluginDocumentSettingPanel>
    </>
  );
}

export default CustomBlockFields;
